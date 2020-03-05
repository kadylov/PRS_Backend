<?php


class Work
{
    private $wid=0;
    private $title="";
    private $authorName="";
    private $authorEmail="";
    private $url="";
    private $tags = "";
    private $dateWritten="";
    private $dateSubmitted="";
    private $retireFlag="";
    private $status="";

    /**
     * Work.class constructor.
     * @param string $title
     * @param string $authorName
     * @param string $url
     * @param array $tags
     * @param string $dateWritten
     * @param string $dateSubmitted
     * @param string $retireFlag
     * @param string $status
     */
    public function __construct($title="", $authorName="", $url="", $tags="", $dateWritten="", $dateSubmitted="", $retireFlag="no", $status="new")
    {
        $this->title = $title;
        $this->authorName = $authorName;
        $this->url = $url;
        $this->tags = $tags;
        $this->dateWritten = $dateWritten;
        $this->dateSubmitted = $dateSubmitted;
        $this->retireFlag = $retireFlag;
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getWid()
    {
        return $this->wid;
    }

    /**
     * @param int $wid
     */
    public function setWid($wid)
    {
        $this->wid = $wid;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * @param string $authorName
     */
    public function setAuthorName($authorName)
    {
        $this->authorName = $authorName;
    }

    /**
     * @return string
     */
    public function getAuthorEmail()
    {
        return $this->authorEmail;
    }

    /**
     * @param string $email
     */
    public function setAuthorEmail($email)
    {
        $this->authorEmail = $email;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return string
     */
    public function getDateWritten()
    {
        return $this->dateWritten;
    }

    /**
     * @param string $dateWritten
     */
    public function setDateWritten($dateWritten)
    {
        $this->dateWritten = $dateWritten;
    }

    /**
     * @return string
     */
    public function getDateSubmitted()
    {
        return $this->dateSubmitted;
    }

    /**
     * @param string $dateSubmitted
     */
    public function setDateSubmitted($dateSubmitted)
    {
        $this->dateSubmitted = $dateSubmitted;
    }

    /**
     * @return string
     */
    public function getRetireFlag()
    {
        return $this->retireFlag;
    }

    /**
     * @param string $retireFlag
     */
    public function setRetireFlag($retireFlag)
    {
        $this->retireFlag = $retireFlag;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }


    public function __toString() {
        try {
            return "\nWork\nTitle: ".(string)$this->getTitle()
                ."\nAuthor: ".(string)$this->getAuthorName()
                ."\nEmail: ".(string)$this->getAuthorEmail()
                ."\nUrl: ".(string)$this->getUrl()
                ."\ntags: ".(string)$this->getTags()
                ."\ndatePublished: ".(string)$this->getDateSubmitted()
                ."\nRetireFlag: ".(string)$this->getRetireFlag()
                ."\nStatus: ".(string)$this->getStatus()
                ."\ndateWritten: ".(string)$this->getDateWritten()."\n";
        } catch (Exception $exception) {
            return 'Error in Reviewer.class:toString';
        }
    }
}
?>
