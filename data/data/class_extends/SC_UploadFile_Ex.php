<?php
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2012 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

require_once CLASS_REALDIR . 'SC_UploadFile.php';

class SC_UploadFile_Ex extends SC_UploadFile {
    // 強制的に仮フォルダの画像を本フォルダに移動
    function moveTempFile2($move_file) {
        $objImage = new SC_Image_Ex($this->temp_dir);
        $objImage->moveTempImage($move_file, $this->save_dir);
        $objImage->deleteImage($move_file, $this->temp_dir);
    }

    // 一時ファイルを保存ディレクトリに移す
    function moveTempFile() {
        if ($this->keyname == '') return;

        parent::moveTempFile();
    }

    // フォームに渡す用のファイル情報配列を返す
    function getFormFileList($temp_url, $save_url, $real_size = false) {
        if ($this->keyname == '') return array();

        return parent::getFormFileList($temp_url, $save_url, $real_size);
    }

    // DB保存用のファイル名配列を返す
    function getDBFileList() {
        if ($this->keyname == '') return array();

        return parent::getDBFileList();
    }

    // 必須判定
    function checkExists($keyname = '') {
        if ($keyname == '') return array();

        return parent::checkExists($keyname);
    }
}
