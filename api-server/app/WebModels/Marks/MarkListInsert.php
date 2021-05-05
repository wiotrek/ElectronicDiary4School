<?php


namespace App\WebModels\Marks;

class MarkListInsert extends MarkInsert {

    private MarkRevision $markRevision;
    private array $marks;

    /**
     * @return MarkRevision
     */
    public function getMarkRevision (): MarkRevision {
        return $this -> markRevision;
    }

    /**
     * @param MarkRevision $markRevision
     */
    public function setMarkRevision ( MarkRevision $markRevision ): void {
        $this -> markRevision = $markRevision;
    }

    /**
     * @return array
     */
    public function getMarks (): array {
        return $this -> marks;
    }

    /**
     * @param MarkInsert $marks
     */
    public function setMarks ( MarkInsert $marks ): void {
        $this -> marks[] = $marks;
    }

}
