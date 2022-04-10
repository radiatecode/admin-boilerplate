<?php

use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use \Illuminate\Support\Arr;

function sentenceDivided($string): array
{
    $divided = explode(" ", $string);
    $numOfWords = count($divided);
    $firstConcat = [];
    for ($i = 0; $i < $numOfWords - 1; $i++) {
        $firstConcat[] = $divided[$i];
    }
    return [
        'first' => implode(" ", $firstConcat),
        'last' => $divided[$numOfWords - 1]
    ];
}

/**
 * Get list of tables where multi tenancy applied by organisation
 * @return array
 * @throws BindingResolutionException
 */
function multiTenancyByOrganisation(): array
{
    $multi = config('multitenancy.byOrganisation');
    $tables = [];
    foreach ($multi as $val) {
        $tableName = app()->make($val)->getTable();
        //array_push($tables,class_basename($val)); /* class_basename('App\Models\Office') */
        array_push($tables, $tableName);
    }

    return $tables;
}

/**
 * check a user is super or not
 * @param null $user_id
 * @return bool
 */
function is_super($user_id = null): bool
{
    return $user_id ? User::find($user_id)->is_super == 1 :
        auth()->user()->is_super == 1;
}

if (!function_exists('arr_get')) {
    function arr_get($array, $key)
    {
        return Arr::get($array, $key);
    }
}

if (!function_exists('findFilesByNamespace')) {
    function findFilesByNamespace($namespace)
    {
        $directory = lcfirst($namespace);

        $path = base_path($directory);

        return glob($path . '\*.php');
    }
}

if (!function_exists('findClassesByNamespace')){
    function findClassesByNamespace($namespace): array
    {
        $fileList = findFilesByNamespace($namespace);

        $classList = [];

        foreach($fileList as $file){
            if (is_file($file)) {
                $fileName = pathinfo($file, PATHINFO_FILENAME);
                $class = $namespace . "\\" . $fileName;
                $classList[] = $class;
            }
        }

        return $classList;
    }
}

if (!function_exists('str_label')) {
    function str_label(string $label): string
    {
        return ucwords(str_replace(['-','_','.'],' ',$label));
    }
}

if (!function_exists('camelCaseToSnakeCase')) {
    function camelCaseToSnakeCase($input): string
    {
        return ltrim(
            strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', $input)),
            '_'
        );
    }
}

if (!function_exists('whiteSpaceInCamelCase')) {
    function whiteSpaceInCamelCase($input)
    {
        // place white space between (PascalCase, camelCase) name
        return preg_replace('/([a-z])([A-Z])/s', '$1 $2', $input);
    }
}

