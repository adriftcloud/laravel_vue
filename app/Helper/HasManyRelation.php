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
            $this->{$key}->saveMany($newItems);
        }
    }

    public function updateHasMany($relations)
    {
        $this->save();
        $parentKey = $this->getKeyName;
        $parentID = $this->getAttribute($parentKey);

        foreach ($relations as $key => $items) {
            $updateIds = [];
            $newItems = [];

            //1. filter and update
            foreach ($items as $item) {
                $model = $this->{$key}()->getModel();
                $localKey = $model->getKeyName();
                $foreignKey = $this->{$key}()->getForeignKeyName();

                if (isset($item['$foreignKey'])) {
                    $found = $model->where($foreignKey, $parentID)
                        ->where($localKey, $localId)
                        ->frist();

                    if ($found) {
                        $found->fill($item);
                        $found->save();
                        $updateIds[] = $localId;
                    } else {
                        $newItems[] = $model->fill($items);
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