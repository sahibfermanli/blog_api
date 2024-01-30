<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ImageRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    protected array $accepted_types = ['jpg', 'png', 'jpeg'];

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if (!blank($value) && $value !== "null") {
            $extension = $value->extension();

            return in_array($extension, $this->accepted_types, true);
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        $types = implode(', ', $this->accepted_types);
        return 'File type invalid, accepted types: ' . $types;
    }
}
