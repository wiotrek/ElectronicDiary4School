<?php


namespace App\ApiModels\Base;

/**
 * The base class of models to create response for called object models
 */
class ApiModel {

    /**
     * Response creator for api models
     */
    public function toString () {
        // Collect data to return variable
        $buildReturn = '{'."\n\t";

        // Get called child object
        $c = static::class;

        // Get properties of called object
        $p = get_class_vars($c);

        // For each property...
        foreach ($p as $name => $value) {

            // Build json depend on property is object
            if (is_object($value))
                $buildReturn .= '"'.$name.'": '.$value.''.','."\n\t";
            // or not
            else
                $buildReturn .= '"'.$name.'": "'.$value.'"'.','."\n\t";

        }


        // Return collected data as json object
        return substr($buildReturn, 0, -3 )."\n".'}';
    }

}
