<?php


namespace App\Traits;


use App\Contracts\WithDataAppendable;

trait HasPrepareValidationData
{
    /**
     * {@inheritdoc}
     *
     * Form request method
     *
     */
    public function prepareForValidation()
    {
        $this->merge($this->append());
    }

    /**
     * Append extra data / modified existing data / sanitize data
     *
     * [These data will be merge with current request for validation]
     *
     * @return array
     */
    protected abstract function append(): array;
}