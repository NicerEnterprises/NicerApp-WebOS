<?php 
require_once(realpath(dirname(__FILE__).'/../../..').'/boot.php');
require_once(dirname(__FILE__).'/boot.php');
require_once(realpath(dirname(__FILE__).'/../../..').'/3rd-party/sag/src/Sag.php');

class class_naForums {
    public $version = '1.0.0';
    public $about = array(
        'whatsThis' => 'NicerApp Forums App Management System PHP class',
        'version' => '1.0.0',
        'history' => array (
            '1.y.z' => 'Initial version'
        ),
        'created' => 'Saturday, 26 March 2022 06:02 CET',
        'copyright' => 'Copyright (c) 2022 by Rene A.J.M. Veerman <rene.veerman.netherlands@gmail.com>'
    );
    
    public $jsMe = 'na.apps.loaded[\'app.2D.forums\']';
    public $cssTheme = 'darkmode';
    public $baseIndentLevel = 3;
    
    public $forumsIndexFilepath;
    public $forumsIndex;
    
    public function __construct() {
        global $naWebOS;
        $this->forumsIndexFilepath = dirname(__FILE__).'/settings/forumsIndex.json';
        $this->forumsIndex = safeJSONload ($this->forumsIndexFilepath);
    }
    
    function filepath ($filename) {
        return realpath(dirname(__FILE__).'/../../../..').'/NicerAppWebOS/apps/nicer.app/app.2D.forums/'.$filename;
    }
    
    // main functions
    public function displayHEAD() {
        global $naWebOS;
        $il = 0;
        $theme = $this->cssTheme;
        $r = $naWebOS->html ($il, '<link type="text/css" rel="stylesheet" media="screen" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">');
        $r.= $naWebOS->html ($il, '<link type="text/css" rel="StyleSheet" media="screen" href="/NicerAppWebOS/apps/nicer.app/app.2D.forums/forums-globals.css?changed='.$naWebOS->fileDateTimeStamp($this->filepath('forums-globals.css')).'">');
        $r.= $naWebOS->html ($il, '<link type="text/css" rel="StyleSheet" media="screen" href="/NicerAppWebOS/apps/nicer.app/app.2D.forums/forums-'.$theme.'.css?changed='.$naWebOS->fileDateTimeStamp($this->filepath('forums-'.$theme.'.css')).'">');
        $r.= $naWebOS->html ($il, '<script type="text/javascript"  src="/NicerAppWebOS/3rd-party/tinymce-4.9.11/js/tinymce/tinymce.min.js"></script>');
        $r.= $naWebOS->html ($il, '<link rel="stylesheet" href="/NicerAppWebOS/3rd-party/tinymce-4/themes/charcoal/skin.min.css">');
        $r.= $naWebOS->html ($il, '<script src="/NicerAppWebOS/3rd-party/jQuery/jquery-ui-1.12.1/jquery-ui.js"></script>');
        $r.= $naWebOS->html ($il, '<script type="text/javascript"  src="/NicerAppWebOS/apps/nicer.app/app.2D.forums/naForums-1.0.0.source.js?changed='.$naWebOS->fileDateTimeStamp($this->filepath('naForums-1.0.0.source.js' )).'"></script>');
        return $r;
    }
    
    public function displayForumIndexPage() {
        global $naWebOS;
        $il = 0;
        $r  = $naWebOS->html($il, '<div class="naForums_header">');
            $r .= $naWebOS->html($il+1,    '<span>Forums</span>');
        $r .= $naWebOS->html($il, '</div>');
        
        $r .= $this->displayForumList($il);
        
        $r .= $naWebOS->html ($il, '<div class="naForums_forumCategory_bottomSpacer">');
        $r .= $naWebOS->html ($il, '</div>');
        
        $r .= $naWebOS->html($il, '<div id="naForums_inputBar_btnAddForumCategory" class="naForums_inputBar naForumCategory_inputBar vividButton_icon_50x50_inputBar">');
            $r .= $naWebOS->html($il+1,    '<input type="text" value="New forum category" style="width:100px;"></input><br/>');
            $r .= $naWebOS->html_vividButton (
                $il+1, 'btnAddForumCategory_save', 'vividButton_icon_50x50 relative', '_50x50', 'relative', 101, '',
                $this->jsMe.'.onclick_btnAddForumCategory_saveCategory()',
                'btnCssVividButton_outerBorder.png',
                'btnCssVividButton.png',
                'btnCssVividButton_iconBackground.png',
                'btnAddForumCategory.png',
                'Add category', 'relative btnAdd forumCategory', ''
            );
        $r .= $naWebOS->html($il, '</div>');
        /*
        $r .= $naWebOS->html($il, '<div id="naForums_buttonBar_btnAddForumCategory" class="naForums_buttonBar vividButton_icon_100x100_buttonBar" style="width:210px;">');
            $r .= $naWebOS->html_vividButton (
                $il+1, 'btnAddForumCategory', 'vividButton_icon_100x100 relative', '_100x100', 'relative', 101, '',
                'naForums.onclick_btnAddForumCategory()',
                'btnCssVividButton_outerBorder.png',
                'btnCssVividButton.png',
                'btnCssVividButton_iconBackground.png',
                'btnAddForumCategory.png',
                'Add category', 'relative', ''
            );
        $r .= $naWebOS->html($il, '</div>');
        */
        return $r;
    }
    
    public function displayForumList($relativeIndentLevel) {
        global $naWebOS;
        $il = $relativeIndentLevel;
        $r  = $naWebOS->html($il, '<div class="naForums_forumsList">');
        $idx = 0;
        foreach ($this->forumsIndex['forumCategories'] as $forumCategoryName => $forumCategoryRec) {
            $r .= $naWebOS->html ($il+1, '<div class="naForums_forumCategory_container">');
            $r .= $naWebOS->html ($il+2, '<div class="naForums_forumCategory">');
            $r .= $naWebOS->html ($il+2, '<span class="naForums_forumCategoryName">'.$forumCategoryName.'</span>');
            $r .= $naWebOS->html ($il+2, '<input class="naForums_forumCategoryName_input" style="display:none;" value="'.$forumCategoryName.'"></input><br/>');
            $r .= $naWebOS->html_vividButton (
                $il+2, 'btnRenameForumCategory', 'vividButton_icon_50x50 grouped btnRename forumCategory', '_50x50', 'grouped', 101, '',
                $this->jsMe.'.onclick_btnRenameForumCategory(event)',
                'btnCssVividButton_outerBorder.png',
                'btnCssVividButton.green2a.png',
                '',//'btnCssVividButton_iconBackground.png',
                'btnEdit2_yellow.png',
                'Rename', 'grouped btnRename forumCategory', ''
            );
            $r .= $naWebOS->html ($il+2, '<div class="naForums_forumButtonSpacer"></div>');
            $r .= $naWebOS->html_vividButton (
                $il+2, 'btnDeleteForumCategory', 'vividButton_icon_50x50 grouped btnDelete forumCategory', '_50x50', 'grouped', 101, '',
                $this->jsMe.'.onclick_btnDeleteForumCategory(event)',
                'btnCssVividButton_outerBorder.png',
                'btnCssVividButton.red1b.png',
                '',//'btnCssVividButton_iconBackground.png',
                'btnDelete.png',
                'Delete', 'grouped btnDelete forumCategory', ''
            );
            $r .= $naWebOS->html ($il+2, '</div>');

            $r .= $naWebOS->html ($il+2, '<div class="naForums_forumCategory_bottomSpacer">');
            $r .= $naWebOS->html ($il+2, '</div>');
            
            foreach ($forumCategoryRec['forums'] as $forumName => $forumRec) {
                $r .= $naWebOS->html ($il+2, '<div class="naForums_forum">');
                $r .= $naWebOS->html ($il+2, '<span class="naForums_forumName">'.$forumName.'</span>');
                $r .= $naWebOS->html ($il+2, '<input class="naForums_forumName_input" style="display:none" value="'.$forumName.'"></input><br/>');
                $r .= $naWebOS->html_vividButton (
                    $il+2, 'btnRenameForum', 'vividButton_icon_50x50 grouped btnRename forum', '_50x50', 'grouped', 101, '',
                    $this->jsMe.'.onclick_btnRenameForum(event)',
                    'btnCssVividButton_outerBorder.png',
                    'btnCssVividButton.blue1a.png',
                    '',//'btnCssVividButton_iconBackground.png',
                    'btnEdit2_cyan.png',
                    'Rename', 'grouped btnRename forum', ''
                );
                $r .= $naWebOS->html ($il+2, '<div class="naForums_forumButtonSpacer"></div>');
                $r .= $naWebOS->html_vividButton (
                    $il+2, 'btnDeleteForum', 'vividButton_icon_50x50 grouped btnDelete forum', '_50x50', 'grouped', 101, '',
                    $this->jsMe.'.onclick_btnDeleteForum(event)',
                    'btnCssVividButton_outerBorder.png',
                    'btnCssVividButton.red1b.png',
                    '',//'btnCssVividButton_iconBackground.png',
                    'btnDelete2.png',
                    'Delete', 'grouped btnDelete forum', ''
                );
                $r .= $naWebOS->html ($il+2, '</div>');
            }            
            
            $r .= $naWebOS->html($il+2, '<div id="naForums_inputBar_btnAddForum" class="naForums_inputBar naForum_inputBar vividButton_icon_50x50_inputBar" style="">');
                $r .= $naWebOS->html($il+3,    '<input id="naForums_input_addForum__'.$idx.'" type="text" value="New forum" style="width:100px;"></input><br/>');
                $r .= $naWebOS->html_vividButton (
                    $il+3, 'btnAddForum_save', 'vividButton_icon_50x50 grouped btnAdd forum', '_50x50', 'relative', 101, '',
                    $this->jsMe.'.onclick_btnAddForum_saveForum(\''.$forumCategoryName.'\', \'naForums_input_addForum__'.$idx.'\')',
                    'btnCssVividButton_outerBorder.png',
                    'btnCssVividButton.png',
                    '',//'btnCssVividButton_iconBackground.png',
                    'btnAddForum.png',
                    'Add forum', 'grouped btnAdd forum', ''
                );
            $r .= $naWebOS->html($il+2, '</div>');
            $r .= $naWebOS->html($il+1, '</div>');
            $idx++;
        }
        $r .= $naWebOS->html($il, '</div>');
        return $r;
    }
    
    public function saveForumsIndex() {
        $this->forumsIndex['forumCategories'] = array_filter ($this->forumsIndex['forumCategories']);
        //var_dump ($this->forumsIndex);
        $x = file_put_contents ($this->forumsIndexFilepath, json_encode ($this->forumsIndex, JSON_PRETTY_PRINT));
        //var_dump ($x);
    }
    
    public function addCategory ($newCategoryName) {
        global $naWebOS;
        $theme = $naForums->cssTheme;
        if (file_exists($this->forumsIndexFilepath)) {
            $forumsIndex = $naWebOS->safeJSONload ($this->forumsIndexFilepath);
        } else {
            $forumsIndex = [
                'forumCategories' => []
            ];
        }
        
        $forumsIndex['forumCategories'][$newCategoryName] = [ 'forums' => [] ];
        $this->forumsIndex = $forumsIndex;
        $this->saveForumsIndex();
        
    }

    public function editCategory ($oldCategoryName, $newCategoryName) {
        global $naWebOS;
        
        if (!is_string($newCategoryName) || $newCategoryName=='') return false;
        
        $theme = $naForums->cssTheme;
        if (file_exists($this->forumsIndexFilepath)) {
            $forumsIndex = safeJSONload ($this->forumsIndexFilepath);
        } else {
            $forumsIndex = [
                'forumCategories' => []
            ];
        }
        
        $forumCategory = $forumsIndex['forumCategories'][$oldCategoryName];
        unset ($forumsIndex['forumCategories'][$oldCategoryName]);
        $forumsIndex['forumCategories'][$newCategoryName] = $forumCategory;
        $this->forumsIndex = $forumsIndex;
        $this->saveForumsIndex();
    }

    public function deleteCategory ($categoryName) {
        global $naWebOS;
        
        $theme = $naForums->cssTheme;
        if (file_exists($this->forumsIndexFilepath)) {
            $forumsIndex = $naWebOS->safeJSONload ($this->forumsIndexFilepath);
        } else {
            $forumsIndex = [
                'forumCategories' => []
            ];
        }
        
        unset ($forumsIndex['forumCategories'][$categoryName]);
        $this->forumsIndex = $forumsIndex;
        $this->saveForumsIndex();
    }

    public function addForum ($categoryName, $newForumName) {
        global $naWebOS;
        $theme = $naForums->cssTheme;
        if (file_exists($this->forumsIndexFilepath)) {
            $forumsIndex = $naWebOS->safeJSONload ($this->forumsIndexFilepath);
        } else {
            $forumsIndex = [
                'forumCategories' => []
            ];
        }
        
        if (!array_key_exists ($categoryName, $forumsIndex['forumCategories'])) 
            $forumsIndex['forumCategories'][$categoryName] = [ 'forums' => [] ];
        
        if (!array_key_exists ($newForumName, $forumsIndex['forumCategories'][$categoryName]['forums'])) 
            $forumsIndex['forumCategories'][$categoryName]['forums'][$newForumName] = [];
        
        $this->forumsIndex = $forumsIndex;
        $this->saveForumsIndex();
    }

    public function editForum ($categoryName, $oldForumName, $newForumName) {
        global $naWebOS;
        
        if (!is_string($newForumName) || $newForumName=='') return false;
        
        $theme = $naForums->cssTheme;
        if (file_exists($this->forumsIndexFilepath)) {
            $forumsIndex = $naWebOS->safeJSONload ($this->forumsIndexFilepath);
        } else {
            $forumsIndex = [
                'forumCategories' => []
            ];
        }
        
        $forumCategory = $forumsIndex['forumCategories'][$categoryName];
        $forum = $forumCategory['forums'][$oldForumName];
        unset ($forumsIndex['forumCategories'][$categoryName]['forums'][$oldForumName]);
        $forumsIndex['forumCategories'][$categoryName]['forums'][$newForumName] = $forum;
        $this->forumsIndex = $forumsIndex;
        $this->saveForumsIndex();
    }

    public function deleteForum ($categoryName, $forumName) {
        global $naWebOS;
        
        $theme = $naForums->cssTheme;
        if (file_exists($this->forumsIndexFilepath)) {
            $forumsIndex = $naWebOS->safeJSONload ($this->forumsIndexFilepath);
        } else {
            $forumsIndex = [
                'forumCategories' => []
            ];
        }
        
        unset ($forumsIndex['forumCategories'][$categoryName]['forums'][$forumName]);
        $this->forumsIndex = $forumsIndex;
        $this->saveForumsIndex();
    }
}
?>
