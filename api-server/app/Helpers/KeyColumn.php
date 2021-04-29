<?php


namespace App\Helpers;

/*
 * Get key column name from model arriving
 */
class KeyColumn {

    // Alphabet of characters to finding capital in exploring name model
    const upperAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * @param $model mixed Relative path to Model name like App/Models/MarksType
     */
    public static function fromModel ( $model ) {

        // extract model class name with change first letter to lowercase
        $modelName = lcfirst(explode( '\\', $model )[2]);

        // find index in the model name when character is capital like studentSubject
        $place = strcspn( $modelName,KeyColumn::upperAlphabet);

        // Does mean that modelName is one word
        if ($place == strlen($modelName))
            $place = 0;

        // Create column id name by model name such as studentSubject -> student_subject_id or teacher -> teacher_id
        return $place != 0
            ? substr( $modelName, 0, $place ) . '_' . substr( $modelName, $place, strlen( $modelName ) ) . '_id'
            : $modelName.'_id';
    }

}
