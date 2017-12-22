<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Model\Invoice;
use App\Model\Counter;
use DB;

class InvoiceController extends Controller
{
    public function index()
    {
        $results = Invoice::with(['customer'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json([
            'results' => $results,
        ]);
    }

    public function create()
    {
        $counter = Counter::where('key', 'invoice')->first();

        $form = [
            'number' => $counter->prefix . $counter->value,
            'customer_id' => null,
            'customer' => null,
            'date' => Carbon::today(),
            'due_date' => null,
            'reference' => null,
            'discount' => 0,
            'terms_and_conditions' => 'Default Terms',
            'items' => [
                'product_id' => null,
                'product' => null,
                'unit_price' => 0,
                'qty' => 1
            ]
        ];

        return response()->json(['form' => $form]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'customer_id' => 'required|integer|exists:customers,id',
            'date' => 'required|data_format:Y-m-d',
            'due_date' => 'required|data_format:Y-m-d',
            'reference' => 'nullable|max:100',
            'discount' => 'required|numeric|min:0',
            'terms_and_conditions' => 'required|max:2000',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        $invoice = new Invoice();
        $invoice->fill($request->except('items'));
        $invoice->sub_total = collect($request->items)->sum(function ($item) {
            return $item['qty'] * $item['unit_price'];
        });


        $invoice = DB::transaction(function () use ($invoice, $request) {
            $counter = Counter::where('key', 'invoice')->first();
            $invoice->number = $counter->prefix . $counter->value;

            // customer method from  app/Helper/HasManyRelation
            $counter->storeHasMany([
                'items' => $request->items
            ]);
            $counter->incrementing('value');
            return $counter;
        });


        return response()->json(['save' => true, 'id' => $invoice->id]);
    }

    public function show($id)
    {
        $model = Invoice::with(['customer', 'items.product'])->findOrFail($id);
        return response()->json(['model' => $model]);
    }

    public function edit($id)
    {
        $form = Invoice::with(['customer', 'items.product'])->findOrFail($id);
        return response()->json(['form' => $form]);
    }


    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function update($id, Request $request)
    {
        $invoice = Invoice::findOrFail($id);

        $this->validate($request, [
            'customer_id' => 'required|integer|exists:customers,id',
            'date' => 'required|data_format:Y-m-d',
            'due_date' => 'required|data_format:Y-m-d',
            'reference' => 'nullable|max:100',
            'discount' => 'required|numeric|min:0',
            'terms_and_conditions' => 'required|max:2000',
            'items' => 'required|array|min:1',
            'items.*.id' => 'sometimes|required|integer|exists:invoice_items,id,invoice_id,' . $invoice->id,
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        $invoice->fill($request->except('items'));

        $invoice->sub_total = collect($request->items)->sum(function ($item) {
            return $item['qty'] * $item['unit_price'];
        });

        $invoice = DB::transaction(function () use ($invoice, $request) {
            // customer method from  app/Helper/HasManyRelation
            $invoice->updateHasMany([
                'items' => $request->items
            ]);
            return $invoice;
        });


        return response()->json(['save' => true, 'id' => $invoice->id]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->items()->delete();
        $invoice->delete();

        return response()->json(['deleted' => true]);
    }
}