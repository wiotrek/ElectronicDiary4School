<?php


namespace App\ApiModels\Notification;


class NotificationResultApiModel {

    #region Private Members

    /**
     * @var int
     */
    private $notificationId;

    /**
     * @var string
     */
    private $avatar;

    /**
     * @var string
     */
    private $fullName;

    /**
     * @var string
     */
    private $dateTime;

    /**
     * @var string
     */
    private $kindOf;

    /**
     * @var boolean
     */
    private $isSender;

    /**
     * @var boolean
     */
    private $isReaded;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $identifier;

    #endregion

    #region Accessors

    /**
     * @return int
     */
    public function getNotificationId (): int {
        return $this -> notificationId;
    }

    /**
     * @param int $notificationId
     */
    public function setNotificationId ( int $notificationId ): void {
        $this -> notificationId = $notificationId;
    }

    /**
     * @return string
     */
    public function getAvatar (): string {
        return $this -> avatar;
    }

    /**
     * @param string $avatar
     */
    public function setAvatar ( string $avatar ): void {
        $this -> avatar = $avatar;
    }

    /**
     * @return string
     */
    public function getFullName (): string {
        return $this -> fullName;
    }

    /**
     * @param string $fullName
     */
    public function setFullName ( string $fullName ): void {
        $this -> fullName = $fullName;
    }

    /**
     * @return string
     */
    public function getDateTime (): string {
        return $this -> dateTime;
    }

    /**
     * @param string $dateTime
     */
    public function setDateTime ( string $dateTime ): void {
        $this -> dateTime = $dateTime;
    }

    /**
     * @return string
     */
    public function getKindOf (): string {
        return $this -> kindOf;
    }

    /**
     * @param string $kindOf
     */
    public function setKindOf ( string $kindOf ): void {
        $this -> kindOf = $kindOf;
    }

    /**
     * @return bool
     */
    public function isSender (): bool {
        return $this -> isSender;
    }

    /**
     * @param bool $isSender
     */
    public function setIsSender ( bool $isSender ): void {
        $this -> isSender = $isSender;
    }

    /**
     * @return bool
     */
    public function isReaded (): bool {
        return $this -> isReaded;
    }

    /**
     * @param bool $isReaded
     */
    public function setIsReaded ( bool $isReaded ): void {
        $this -> isReaded = $isReaded;
    }

    /**
     * @return string
     */
    public function getSubject (): string {
        return $this -> subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject ( string $subject ): void {
        $this -> subject = $subject;
    }

    /**
     * @return string
     */
    public function getMessage (): string {
        return $this -> message;
    }

    /**
     * @param string $message
     */
    public function setMessage ( string $message ): void {
        $this -> message = $message;
    }

    /**
     * @return string
     */
    public function getIdentifier (): string {
        return $this -> identifier;
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier ( string $identifier ): void {
        $this -> identifier = $identifier;
    }

    #endregion

}
