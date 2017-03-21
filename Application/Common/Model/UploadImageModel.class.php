<?php
namespace Common\Model;

use Think\Model;

class UploadImageModel extends Model {
    private $_uploadobj;

    const UPLOAD = 'upload';
    
    public function __construct() {
//        parent::__construct();
        $this->_uploadobj = new \Think\Upload();
        $this->_uploadobj->rootPath = "./".self::UPLOAD."/";
        $this->_uploadobj->subName = date("Y")."/".date("m")."/".date("d");
    }

    public function imageUpload() {
        $res = $this->_uploadobj->upload();
        if ( $res ) {
            return "/".self::UPLOAD."/".$res['file']['savepath'].$res['file']['savename'];
        } else {
            return false;
        }
    }

    public function upload() {
        $res = $this->_uploadobj->upload();
        if ( $res ) {
            return "/".self::UPLOAD."/".$res['imgFile']['savepath'].$res['imgFile']['savename'];
        } else {
            return false;
        }
    }
}