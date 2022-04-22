<?php


namespace App\Traits;


trait HasValidatedData
{
    /**
     * {@inheritdoc}
     *
     * Form request method
     *
     */
    public function validated()
    {
        $inputs = parent::validated();

        return array_merge($inputs,$this->append());
    }

    /**
     * Append extra data / modified existing data / sanitize data
     *
     * [These data will be merge with current request's validated data]
     *
     * @return array
     */
    protected abstract function append(): array;
}