<?php
/**
 * Zalo © 2019
 *
 */

namespace Zalo\Builder;

use Zalo\Exceptions\ZaloSDKException;

/**
 * Class MessageBuilder
 *
 * @package Zalo
 */
class MessageBuilder
{
    /**
     * @const string recipient
     */
    const RECIPIENT = 'recipient';
    /**
     * @const string text
     */
    const TEXT = 'text';
    /**
     * @const string attachment_id
     */
    const ATTACHMENT_ID = 'attachment_id';
    /**
     * @const string template_id
     */
    const TEMPLATE_ID = 'template_id';
    /**
     * @const string template_data
     */
    const TEMPLATE_DATA = 'template_data';
    /**
     * @const string token
     */
    const FILE_TOKEN = 'token';
    /**
     * @const string media_type
     */
    const MEDIA_TYPE = 'media_type';
    /**
     * @const string template_type
     */
    const TEMPLATE_TYPE = 'template_type';
    /**
     * @const string media_height
     */
    const MEDIA_HEIGHT = 'media_height';
    /**
     * @const string media_width
     */
    const MEDIA_WIDTH = 'media_width';
    /**
     * @const string element
     */
    const ELEMENT = 'element_';
    /**
     * @const string button
     */
    const BUTTON = 'button_';
    /**
     * @const string msg type text
     */
    const MSG_TYPE_TXT = 'text';
    /**
     * @const string msg type media
     */
    const MSG_TYPE_MEDIA = 'media';
    /**
     * @const string msg type list
     */
    const MSG_TYPE_LIST = 'list';
    /**
     * @const string msg type file
     */
    const MSG_TYPE_FILE = 'file';
    /**
     * @const string  msg type template
     */
    const MSG_TYPE_TEMPLATE = 'template';
    /**
     * @const string max element
     */
    const MAX_ELEMENT = 5;
    /**
     * @var string The message type.
     */
    protected $type;
    /**
     * @var string The element index.
     */
    protected $elementIndex;
    /**
     * @var string The app button index.
     */
    protected $buttonIndex;
    /**
     * @var string The params data.
     */
    protected $data;

    /**
     * The constructor
     * 
     * @param string $msgTyoe
     *
     * @throws ZaloSDKException
     */
    public function __construct($msgType)
    {
        if (!is_string($msgType)) {
            if (static::MSG_TYPE_TXT !== $msgType || static::MSG_TYPE_MEDIA !== $msgType || static::MSG_TYPE_LIST !== $msgType ||
                static::MSG_TYPE_FILE !== $msgType || static::MSG_TYPE_TEMPLATE !== $msgType) {
                    throw new ZaloSDKException('only support 5 message type text, media, list, template, file');
                }
                throw new ZaloSDKException('message type is empty! only support 5 message type text, media, list, template, file');
        }
        $this->elementIndex = 0;
        $this->buttonIndex = 0;
        $this->data = array(
            static::MEDIA_TYPE => "image",
            static::TEMPLATE_TYPE => "invite",
            static::MEDIA_HEIGHT => 280,
            static::MEDIA_WIDTH => 500
        );
        $this->type = $msgType;
    }

    /**
     * Set media type
     * 
     * @param string $type
     *
     * @throws ZaloSDKException
     */
    public function withMediaType($type)
    {
        if ('image' !== $type && 'gif' !== $type) {
            throw new ZaloSDKException('media type only support type image, gif');
        }
        $this->data[static::MEDIA_TYPE] = $type;
    }

    /**
     * Set template type
     * 
     * @param string $type
     *
     * @throws ZaloSDKException
     */
    public function withTemplateType($type)
    {
        if ('invite' !== $type) {
            throw new ZaloSDKException('template type only support invite');
        }
        $this->data[static::TEMPLATE_TYPE] = $type;
    }

    /**
     * Set media size
     * 
     * @param string $width
     * @param string $height
     *
     */
    public function withMediaSize($height, $width)
    {
        $this->data[static::MEDIA_HEIGHT] = $height;
        $this->data[static::MEDIA_WIDTH] = $width;
    }

    /**
     * Set user_id
     * 
     * @param string $id
     *
     */
    public function withUserId($id)
    {
        $recipient = array(
            'user_id' => $id
        );
        $this->data[static::RECIPIENT] = $recipient;
    }

    /**
     * Set phone number
     * 
     * @param string $phone
     *
     */
    public function withPhoneNumber($phone)
    {
        $recipient = array(
            'phone' => $phone
        );
        $this->data[static::RECIPIENT] = $recipient;
    }

    /**
     * Set message id
     * 
     * @param string $mid
     *
     */
    public function withMessageId($mid)
    {
        $recipient = array(
            'message_id' => $mid
        );
        $this->data[static::RECIPIENT] = $recipient;
    }

    /**
     * Set group id
     * 
     * @param string $gid
     *
     */
    public function withGroupId($gid)
    {
        $recipient = array(
            'group_id' => $gid
        );
        $this->data[static::RECIPIENT] = $recipient;
    }

    /**
     * Set text
     * 
     * @param string $content
     *
     */
    public function withText($content)
    {
        $this->data[static::TEXT] = $content;
    }

    /**
     * Set file token
     * 
     * @param string $token
     *
     */
    public function withFileToken($token) {
        $this->data[static::FILE_TOKEN] = $token;
    }

    /**
     * Set attachment id
     * 
     * @param string $attachmentId
     *
     */
    public function withAttachment($attachmentId) {
        $this->data[static::ATTACHMENT_ID] = $attachmentId;
    }

    /**
     * Set template & template data
     * 
     * @param string $attachmentId
     * @param string $data
     */
    public function withTemplate($templateId, $data) {
        $this->data[static::TEMPLATE_ID] = $templateId;
        $this->data[static::TEMPLATE_DATA] = $data;
    }

    /**
     * Build action open url
     * 
     * @param string $url
     *
     */
    public function buildActionOpenURL($url)
    {
        $action = array(
            'type' => 'oa.open.url',
            'url' => $url
        );
        return $action;
    }

    /**
     * Build action query show
     * 
     * @param string $callbackData
     *
     */
    public function buildActionQueryShow($callbackData)
    {
        $action = array(
            'type' => 'oa.query.show',
            'payload' =>  $callbackData
        );
        return $action;
    }

    /**
     * Build action query hide
     * 
     * @param string $callbackData
     *
     */
    public function buildActionQueryHide($callbackData)
    {
        $action = array(
            'type' => 'oa.query.hide',
            'payload' =>  $callbackData
        );
        return $action;
    }

    /**
     * Build action open phone
     * 
     * @param string $phoneNumber
     *
     */
    public function buildActionOpenPhone($phoneNumber)
    {
        $action = array(
                'type' => 'oa.open.phone',
                'payload' =>  array(
                    'phone_code' => $phoneNumber
                )
        );
        return $action;
    }

    /**
     * Build action open SMS
     * 
     * @param string $phoneNumber
     * @param string $smsText
     */
    public function buildActionOpenSMS($phoneNumber, $smsText)
    {
        $action = array(
                'type' => 'oa.open.sms',
                'payload' =>  array(
                    'phone_code' => $phoneNumber,
                    'content' => $smsText
                )
        );
        return $action;
    }

    /**
     * Add message element
     * 
     * @param string $title
     * @param string $thumb
     * @param string $description
     * @param string $action
     */
    public function withElement($title, $thumb, $description, $action)
    {
        if ($this->elementIndex >= static::MAX_ELEMENT) {
            throw new ZaloSDKException('Only support 4 elements');
        }
        $element = array(
            'title' => $title,
            'image_url' => $thumb,
            'subtitle' => $description,
            'default_action' => $action
        );
        $this->data[static::ELEMENT . $this->elementIndex] = $element;
        $this->elementIndex++;
    }

    /**
     * Add message button
     * 
     * @param string $title
     * @param string $action
     */
    public function withButton($title, $action)
    {
        if ($this->buttonIndex >= static::MAX_ELEMENT) {
            throw new ZaloSDKException('Only support 4 buttons');
        }
        if ($action['type'] == 'oa.open.url') {
            $url = $action['url'];
            $action['payload']  = array('url' => $url);
        }
        $button = array(
            'title' => $title,
            'type' => $action['type'],
            'payload' => $action['payload']
        );
        $this->data[static::BUTTON . $this->buttonIndex] = $button;
        $this->buttonIndex++;
    }

    /**
     * Build buttons
     */
    private function buildButtons() {
        $buttons = array();
        for ($i = 0; $i < $this->buttonIndex; $i++) {
            array_push($buttons, $this->data[static::BUTTON . $i]);
        } 
        return $buttons;
    }

    /**
     * Build elements
     */
    private function buildElements() {
        $elements = array();
        for ($i = 0; $i < $this->elementIndex; $i++) {
            array_push($elements, $this->data[static::ELEMENT . $i]);
        }
        return $elements;
    }

    /**
     * Build message
     */
    public function build() {
        switch ($this->type) {
            case 'text':
                $message = array(
                    'recipient' => $this->data[static::RECIPIENT],
                    'message' =>array(
                        'text' =>  $this->data[static::TEXT],
                        'attachment' => array(
                            'type' => 'template',
                            'payload' => array(
                                'buttons' => $this->buildButtons()
                            ) 
                        )
                    )
                );
                return $message;
            case 'media':
                $message = array(
                    'recipient' => $this->data[static::RECIPIENT],
                    'message' =>array(
                        'text' =>  $this->data[static::TEXT],
                        'attachment' => array(
                            'type' => 'template',
                            'payload' => array(
                                'template_type' => 'media',
                                'elements' => array(
                                    array(
                                        'media_type' => $this->data[static::MEDIA_TYPE],
                                        'attachment_id' => $this->data[static::ATTACHMENT_ID],
                                        "width" => $this->data[static::MEDIA_WIDTH],
                                        "height" => $this->data[static::MEDIA_HEIGHT]
                                    )
                                ),
                                'buttons' => $this->buildButtons()
                            ) 
                        )
                    )
                );
                return $message;
            case 'list':
                $message = array(
                    'recipient' => $this->data[static::RECIPIENT],
                    'message' =>array(
                        'attachment' => array(
                            'type' => 'template',
                            'payload' => array(
                                'template_type' => 'list',
                                'elements' => $this->buildElements(),
                                'buttons' => $this->buildButtons()
                            ) 
                        )
                    )
                );
                return $message;
            case 'file':
                $message = array(
                    'recipient' => $this->data[static::RECIPIENT],
                    'message' =>array(
                        'attachment' => array(
                            'type' => 'file',
                            'payload' => array(
                                'token' => $this->data[static::FILE_TOKEN],
                                'buttons' => $this->buildButtons()
                            )
                        )
                    )
                );
                return $message;
            case 'template':
                $message = array(
                    'recipient' => $this->data[static::RECIPIENT],
                    'message' =>array(
                        'attachment' => array(
                            'type' => 'template',
                            'payload' => array(
                                'template_type' => $this->data[static::TEMPLATE_TYPE],
                                'elements' => array(
                                    array(
                                        'template_id' => $this->data[static::TEMPLATE_ID],
                                        'template_data' => $this->data[static::TEMPLATE_DATA]
                                    )
                                )
                            ) 
                        )
                    )
                );
                return $message;
            default:
                break;
        }
        return array();
    }
}
