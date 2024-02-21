<?php

namespace App\Validations;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TransactionValidation
{
    /**
     * Error check
     *
     * @var bool $fails
     */
    private static $fails = FALSE;

    /**
     * Error results
     *
     * @var array $fails
     */
    private static $errors = [];

    /**
     * Values results
     *
     * @var array $fails
     */
    private static $validated = [];

    /**
     * Running
     *
     * @var array $fails
     */
    private static $run = FALSE;

    /**
     * Rules validation
     *
     * @return array
     */
    private static function rules()
    {
        return [
            "product_id" => [
                "required", "integer", Rule::unique('transactions', 'id'), Rule::exists('products', 'id')
            ]
        ];
    }

    /**
     * Running validation
     *
     */
    private static function run()
    {
        // \dd(static::rules());
        static::$run = Validator::make(\request()->all(), static::rules());
        static::$fails = static::$run->fails();
        static::$errors = static::$run->errors();
    }

    /**
     * Get errors
     *
     */
    public static function errors()
    {
        return static::$errors;
    }

    /**
     * Get fails
     *
     */
    public static function fails()
    {
        return static::$fails;
    }

    /**
     * Process check validation
     *
     */
    public static function check()
    {
        static::run();
    }

    /**
     * Get values validated
     *
     */
    public static function validated()
    {
        return static::$run->validated();
    }
}
