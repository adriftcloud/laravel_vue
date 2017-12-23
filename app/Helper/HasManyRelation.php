<?php

namespace App\Helper;

trait HasManyRelation
{
    public function storeHasMany($relations)
    {
        $this->save();

        foreach ($relations as $key => $items) {
            $newItems = [];

            foreach ($items as $item) {
                $model = $this->{$key}()->getModel();
                $newItems[] = $model->fill($item);
            }

            //save
            $this->{$key}()->saveMany($newItems);
        }
    }

    public function updateHasMany($relations)
    {
        $this->save();
        $parentKey = $this->getKeyName();
        \Debugbar::info('$parentKey=' . $parentKey);
        $parentID = $this->getAttribute($parentKey);
        \Debugbar::info('$parentID=' . $parentID);

        foreach ($relations as $key => $items) {
            $updateIds = [];
            $newItems = [];

            //1. filter and update
            foreach ($items as $item) {
                $model = $this->{$key}()->getModel();
                $localKey = $model->getKeyName();
                \Debugbar::info('$localKey=' . $localKey);
                $foreignKey = $this->{$key}()->getForeignKeyName();
                \Debugbar::info('$foreignKey=' . $foreignKey);

                if (isset($item[$localKey])) {
                    $localId = $item[$localKey];
                    \Debugbar::info('$localId=' . $localId);
                    $found = $model->where($foreignKey, $parentID)
                        ->where($localKey, $localId)
                        ->first();

                    if ($found) {
                        $found->fill($item);
                        $found->save();
                        $updateIds[] = $localId;
                    } else {
                        \Debugbar::info('$item');
                        \Debugbar::info($item);
                        $newItems[] = $model->fill($item);
                    }
                }
            }

            //2. delete non-updates items
            $model = $this->{$key}()->getModel();
            $localKey = $model->getKeyName();
            $foreignKey = $this->{$key}()->getForeignKeyName();
            $model->whereNotIn($localKey, $updateIds)
                ->where($foreignKey, $parentID)
                ->delete();

            //3. save new items
            if (count($newItems)) {
                $this->{$key}()->saveMany($newItems);
            }
        }

    }
}