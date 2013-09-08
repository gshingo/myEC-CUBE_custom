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

require_once CLASS_REALDIR . 'SC_CheckError.php';

class SC_CheckError_Ex extends SC_CheckError {
    /**
     * HTMLのタグをチェックする
     * Warning回避のためのオーバーライド
     *
     * @param array $value value[0] = 項目名 value[1] = 判定対象 value[2] = 許可するタグが格納された配列
     * @return void
     */
    function HTML_TAG_CHECK($value) {
        if (isset($this->arrErr[$value[1]])) {
            return;
        }
        $this->createParam($value);
        // HTMLに含まれているタグを抽出する
        preg_match_all('/<\/?([a-z]+)/i', $this->arrParam[$value[1]], $arrTagIncludedHtml = array());

        //$arrDiffTag = array_diff($arrTagIncludedHtml[1], $value[2]);
        $arrDiffTag = array_diff((array)$arrTagIncludedHtml[1], (array)$value[2]);

        if (empty($arrDiffTag)) return;

        // 少々荒っぽいが、表示用 HTML に変換する
        foreach ($arrDiffTag as &$tag) {
            $tag = '[' . htmlspecialchars($tag) . ']';
        }
        $html_diff_tag_list = implode(', ', $arrDiffTag);

        $this->arrErr[$value[1]] = '※ ' . $value[0] . 'に許可されていないタグ ' . $html_diff_tag_list . ' が含まれています。<br />';
    }

}
