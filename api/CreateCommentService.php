<?php


namespace LearnLocApi;

/**
 * Class CreateCommentService
 *
 * @author Stefan Wanzenried <sw@studer-raimann.ch>
 */
class CreateCommentService implements Service
{

    /**
     * @var int
     */
    protected $location_id = 0;

    /**
     * @var int
     */
    protected $parent_id = 0;

    /**
     * @var int
     */
    protected $user_id = 0;

    /**
     * @var array
     */
    protected $data = array(
        'title' => '',
        'body' => '',
        'image' => '', // Base64 encoded
    );


    /**
     * @param $location_id
     * @param $parent_id
     * @param $data
     * @param int $user_id
     */
    function __construct($location_id, $parent_id, $data, $user_id = 0)
    {
        global $ilUser;

        $this->location_id = $location_id;
        $this->parent_id = $parent_id;
        $this->user_id = $user_id ? $user_id : $ilUser->getId();
        $this->data = array_merge($this->data, $data);
    }


    /**
     * @return mixed
     */
    public function getResponse()
    {
        try {
            $this->createComment();

            return array('success' => 'Successfully created comment');
        } catch (\Exception $e) {
            return array('error' => $e->getMessage());
        }
    }


    protected function createComment()
    {
        $comment = new \ilLearnLocComment();
        $comment->setRefId($this->location_id); // It's the object ID!
        $comment->setTitle($this->data['title']);
        $comment->setBody($this->data['body']);
        $comment->setParentId($this->parent_id);
        $comment->setUserId($this->user_id);
        if ($this->data['image']) {
            $mob = new \ilLearnLocMedia();
            $mob->setTitle('lelcommentmob');
            $mob->create();
            $name = '/img_ws_' . time() . '_' . rand(1000, 9999) . '.jpg';
            $file_upload = $mob->getPath() . $name;
            file_put_contents($file_upload, base64_decode($this->data['image']));
            $file['image']['tmp_name'] = $file_upload;
            $file['image']['name'] = $name;
            $mob->setFile($file);
            $mob->addImage();
            $mob_id = $mob->getId();
            $comment->setMediaId($mob_id);
        }
        $comment->setCreationDate(time());
        $comment->create();
    }
}