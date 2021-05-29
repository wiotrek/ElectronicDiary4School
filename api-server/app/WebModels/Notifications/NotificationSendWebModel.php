<?php


namespace App\WebModels\Notifications;

/**
 * The notification which is sended by parent or teacher between them
 */
class NotificationSendWebModel {

    #region Private Members

    /**
     * @var string | null Types of the message from notification_type table
     */
    private $kindOf;

    /**
     * @var string | null The message of notification from sender
     */
    private $content;

    /**
     * @var string | null The author message identifier
     */
    private $sender;

    /**
     * @var string | null The identifier reader message person
     */
    private $receiver;

    /**
     * @var string | null The time of  message which is sended by sender with format yyyy-MM-dd HH:mm
     */
    private $dateTime;

    #endregion

    #region Accessors

    /**
     * @return string
     */
    public function getKindOf (): ?string {
        return $this -> kindOf;
    }

    /**
     * @param string|null $kindOf
     */
    public function setKindOf ( ?string $kindOf ): void {
        $this -> kindOf = $kindOf;
    }

    /**
     * @return string
     */
    public function getContent (): ?string {
        return $this -> content;
    }

    /**
     * @param string|null $content
     */
    public function setContent ( ?string $content ): void {
        $this -> content = $content;
    }

    /**
     * @return string
     */
    public function getSender (): ?string {
        return $this -> sender;
    }

    /**
     * @param string|null $sender
     */
    public function setSender ( ?string $sender ): void {
        $this -> sender = $sender;
    }

    /**
     * @return string
     */
    public function getReceiver (): ?string {
        return $this -> receiver;
    }

    /**
     * @param string|null $receiver
     */
    public function setReceiver ( ?string $receiver ): void {
        $this -> receiver = $receiver;
    }

    /**
     * @return string
     */
    public function getDateTime (): ?string {
        return $this -> dateTime;
    }

    /**
     * @param string|null $dateTime
     */
    public function setDateTime ( ?string $dateTime ): void {
        $this -> dateTime = $dateTime;
    }

    #endregion

}
