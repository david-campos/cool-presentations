<?php
/**
 * @author David Campos Rodríguez <david.campos.r96@gmail.com>
 */

namespace domain;

class Presentation {
    /** @var string code which identifies the presentation */
    private $idCode;
    /** @var string name of the presentation to be displayed */
    private $name;
    /** @var string starting timestamp of the presentation */
    private $start;
    /** @var string ending timestamp of the presentation */
    private $end;
    /** @var boolean indicates if the presentation has an access code */
    private $withAccessCode;
    /** @var [lat=>double,lon=>double] indicates the location of the presentation */
    private $location;
    /** @var boolean determines if a 'download' button should appear or not */
    private $downloadable;
    /** @var string user id of the author of the presentation */
    private $author;

    /**
     * Presentation constructor. Creates a new presentation.
     * @param int $idCode
     * @param string $name
     * @param string $start
     * @param string $end
     * @param bool $withAccessCode
     * @param array $location
     * @param bool $downloadable
     * @param string $author
     */
    public function __construct(
        $idCode=-1, $name='', $start='', $end='', $withAccessCode=false,
        $location=[], $downloadable=false, $author='') {
            $this->idCode = $idCode;
            $this->name = $name;
            $this->start = $start;
            $this->end = $end;
            $this->withAccessCode = $withAccessCode;
            $this->location = $location;
            $this->downloadable = $downloadable;
            $this->author = $author;
    }


}