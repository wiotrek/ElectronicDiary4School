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
     * @var string | null The identifier reader message person
     */
    private $receiver;

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
    public function getReceiver (): ?string {
        return $this -> receiver;
    }

    /**
     * @param string|null $receiver
     */
    public function setReceiver ( ?string $receiver ): void {
        $this -> receiver = $receiver;
    }

    #endregion

}
