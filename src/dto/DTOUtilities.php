<?php

namespace Service\Api\dto;

class DTOUtilities
{
    public function cleanFields()
    {
        $dataFilter = array_filter((array) $this, fn($n) => $n != null);

        return $dataFilter;
    }

    public function cleanToUpdate()
    {
        $dataFilter = $this->cleanFields();
        $dataKeys = array_keys($dataFilter);
        $noIdFields = array_filter($dataKeys, fn($n) => $n != "id");
        $dataFormatted = array_map(fn($d) => "\"$d\" = :$d", $noIdFields);

        return implode(",", $dataFormatted);
    }

    public function cleanToInsert()
    {
        $dataFilter = $this->cleanFields();
        $dataKeys = array_keys($dataFilter);
        $dataFormatted = array_map(fn($d) => ":$d", $dataKeys);

        return implode(",", $dataFormatted);
    }

    public function cleanToColumn()
    {
        $dataFilter = $this->cleanFields();
        $dataKeys = array_keys($dataFilter);
        $dataFormatted = array_map(fn($d) => "\"$d\"", $dataKeys);

        return implode(",", $dataFormatted);
    }
}
