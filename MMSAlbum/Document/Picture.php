<?php

namespace MMSAlbum\Document;



/**
 * MMSAlbum\Document\Picture
 */
class Picture
{
    /**
     * @var MongoId $id
     */
    protected $id;

    /**
     * @var date $uploadTime
     */
    protected $uploadTime;

    /**
     * @var string $pictureTitle
     */
    protected $pictureTitle;

    /**
     * @var string $description
     */
    protected $description;

    /**
     * @var string $userId
     */
    protected $userId;

    /**
     * @var string $username
     */
    protected $username;

    /**
     * @var string $url
     */
    protected $url;

    /**
     * @var string $schoolId
     */
    protected $schoolId;


    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set uploadTime
     *
     * @param date $uploadTime
     * @return \Picture
     */
    public function setUploadTime($uploadTime)
    {
        $this->uploadTime = $uploadTime;
        return $this;
    }

    /**
     * Get uploadTime
     *
     * @return date $uploadTime
     */
    public function getUploadTime()
    {
        return $this->uploadTime;
    }

    /**
     * Set pictureTitle
     *
     * @param string $pictureTitle
     * @return \Picture
     */
    public function setPictureTitle($pictureTitle)
    {
        $this->pictureTitle = $pictureTitle;
        return $this;
    }

    /**
     * Get pictureTitle
     *
     * @return string $pictureTitle
     */
    public function getPictureTitle()
    {
        return $this->pictureTitle;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return \Picture
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return \Picture
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * Get userId
     *
     * @return string $userId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return \Picture
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Get username
     *
     * @return string $username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return \Picture
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Get url
     *
     * @return string $url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set schoolId
     *
     * @param string $schoolId
     * @return \Picture
     */
    public function setSchoolId($schoolId)
    {
        $this->schoolId = $schoolId;
        return $this;
    }

    /**
     * Get schoolId
     *
     * @return string $schoolId
     */
    public function getSchoolId()
    {
        return $this->schoolId;
    }
}