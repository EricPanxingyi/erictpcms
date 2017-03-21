<?php
/**
 * json格式传值
 * @param int $status
 * @param string$message
 * @param array $data
 * @return string
 */
function show($status, $message, $data=array()) {
    $result = array(
        'status' => $status,
        'message' => $message,
        'data' => $data
    );
    exit(json_encode($result));
}

/**
 * 密码加密
 * @param string $password
 * @return string
 */
function getMd5Password($password) {
    return md5($password.C('MD5_PRE'));
}

/**
 * 显示类型名称
 * @param int $type
 * @return string
 */
function getMenuType($type) {
    if ($type == 1) return '后台菜单';
    return '前台栏目';
}

/**
 * 显示状态
 * @param int $status
 * @return string
 */
function getStatus($status) {
    if ($status == 1) {
        return '开启';
    } elseif ($status == 0) {
        return '关闭';
    } else {
        return '删除';
    }
}

/**
 * 获取菜单url
 * @param array $nav
 * @return string
 */
function getMenuUrl($nav) {
    if ( $nav['f'] == 'index' ) {
        $url = "/admin.php?c=" . $nav['c'];
    } else {
        $url = "/admin.php?c=" . $nav['c'] . "&a=" . $nav['f'];
    }
    return $url;
}

/**
 * 获取高亮
 * @param string $nav_c
 * @return string
 */
function getActive($nav_c) {
    $current_c = strtolower(CONTROLLER_NAME);
    if ( $current_c == strtolower($nav_c) ) {
        return 'class="active"';
    } else {
        return '';
    }
}

/**
 * kindeditor数据传递
 * @param int $status
 * @param string $data
 */
function showKind($status,$data) {
    header("content-type:application/json;charset:utf-8");
    if($status == 0 ){
        exit(json_encode(array('error' => 0, 'url' => $data)));
    }else{
        exit(json_encode(array('error' => 1, 'message' => "Upload Fail!")));
    }
}

/**
 * 获取登录用户名
 * @return string
 */
function getLoginName() {
    return $_SESSION['adminUser']['username'] ? $_SESSION['adminUser']['username'] : '';
}

/**
 * 获取栏目名称
 * @param array $menus
 * @param int $catid
 * @return string
 */
function getCatName($menus, $catid) {
    foreach ( $menus as $menu ) {
        $catlist[$menu['menu_id']] = $menu['name'];
    }
    return isset($catlist[$catid]) ? $catlist[$catid] : '';
}

/**
 * 获取来源名称
 * @param int $id
 * @return string
 */
function getCopyfrom($id) {
    $from = C("COPY_FROM");
    return isset($from[$id]) ? $from[$id] : '';
}

/**
 * 获取推荐位名称
 * @param array $positions
 * @param int $position_id
 * @return string
 */
function getPositionName($positions, $position_id) {
    foreach ( $positions as $position ) {
        $positionlist[$position['id']] = $position['name'];
    }
    return isset($positionlist[$position_id]) ? $positionlist[$position_id] : '';
}

/**
 *
 * @param string $path
 * @return string
 */
function isThumb($path) {
    if ( $path ) {
        return "<img src='".$path."' width='50' height='50'>";
    } else {
        return "<span>无缩略图</span>";
    }
}

/**
 * 中文字符串截取
 * @param string $str
 * @param int $start
 * @param int $length
 * @param string $charset
 * @param bool $suffix
 * @return string
 */
function msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = true) {
    if ( empty($str) ) {
        return;
    }
    $sourcestr = $str;
    $cutlength = $length;
    $returnstr = '';
    $i = 0;
    $n = 0.0;
    $str_length = strlen($sourcestr); //字符串的字节数
    while ( $n < $cutlength && $i < $str_length ) {
        $temp_str = substr($sourcestr, $i, 1);
        $ascnum = ord($temp_str);
        if ( $ascnum >= 252 ) {
            $num = 6;
            $n++;
        } elseif ( $ascnum >= 248 ) {
            $num = 5;
            $n++;
        } elseif ( $ascnum >= 240 ) {
            $num = 4;
            $n++;
        } elseif ( $ascnum >= 224 ) {
            $num = 3;
            $n++;
        } elseif ( $ascnum >= 192 ) {
            $num = 2;
            $n++;
        } elseif ( $ascnum >= 65 && $ascnum <= 90 && $ascnum != 73 ) {
            $num = 1;
            $n++;
        } elseif ( !(array_search($ascnum, array(37, 38, 64, 109, 119)) === FALSE) ) {
            $num = 1;
            $n++;
        } else {
            $num = 1;
            $n = $n + 0.5;
        }
        if( $n < $cutlength-0.5 ){
            $returnstr = $returnstr . substr($sourcestr, $i, $num);
            $i = $i + $num;
        }
    }
    if ( $i < $str_length && $suffix ) {
        $returnstr = $returnstr . '…';
    }
    return $returnstr;
}

/**
 * $index(1=>首页 2=>新闻 3=>汽车 4=>体育 5=>科技)
 * @param int $index
 * @param string $controll_name
 * @return string
 */
function public_uri($index,$controll_name="") {
    if( $controll_name && $controll_name == 'Index' ) {
        return "curr";
    }
    $uri = $_SERVER['REQUEST_URI'];
    preg_match("/article\/(\d+)\/(\d+)$/", $uri, $a);
    $return = "";
    switch ( $index ) {
        //新闻
        case 2:
            if ( stripos($uri, '/news') !== false || $a[1] == 5 ) {
                $return = "curr";
            }
            break;
        //汽车
        case 3:
            if ( stripos($uri, '/cars') !== false || $a[1] == 3 ) {
                $return = "curr";
            }
            break;
        //体育
        case 4:
            if ( stripos($uri, '/sports') !== false || $a[1] == 4 ) {
                $return = "curr";
            }
            break;
        //科技
        case 5:
            if ( stripos($uri, '/techs') !== false || $a[1] == 7 ) {
                $return = "curr";
            }
            break;
    }
    return $return;
}

/**
 * 判断是否为空 为空输出无
 * @param $string
 * @return string
 */
function isEmpty($string) {
    if ( $string ) return $string;
    return "---";
}

/**
 * 判断图片是否为空
 * @param $string
 * @return string
 */
function isPicEmpty($string) {
    if ( $string ) return $string;
    return "/Public/images/IMG_3485.JPG";
}