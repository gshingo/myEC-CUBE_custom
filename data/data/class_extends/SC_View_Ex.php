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

require_once CLASS_REALDIR . 'SC_View.php';

class SC_View_Ex extends SC_View {
    /**
     * テンプレートパスをアサインする.
     *
     * @param integer $device_type_id 端末種別ID
     */
    function assignTemplatePath($device_type_id) {
        // FIXME:下記３つは別のところに実装するべき...
        // レイアウトデザインを取得
        $layout = new SC_Helper_PageLayout_Ex();
        $objDb = new SC_Helper_DB_Ex();
        $layout->sfGetPageLayout($this, false, P_LIST_URLPATH);
        $this->arrRet = $objDb->sfGetBasisData();
        $arrInfo['arrRayoutInfo'] = $this->arrRet;
        foreach ($arrInfo as $key => $value){
            $this->assign($key, $value);
        }
        // 各地送料を取得
        $this->arrDelivefee = $objDb->sfGetDelivFeeData();
        $arrInfo['arrDelivefee'] = $this->arrDelivefee;
        foreach ($arrInfo['arrDelivefee'] as $key => $value){
            $this->assign("fee".$key, $value);
        }
        // ログイン判定
        $this->assign('TPL_LOGIN', false);
        $objCustomer = new SC_Customer_Ex();
        if ($objCustomer->isLoginSuccess()) {
            $this->assign('TPL_LOGIN', true);
        }

        //parent::assignTemplatePath($device_type_id);
        // テンプレート変数を割り当て
        $this->assign('TPL_URLPATH', SC_Helper_PageLayout_Ex::getUserDir($device_type_id, true));

        // FIXME:何故、追加されたのか...
        // GETのカテゴリIDを元に正しいカテゴリIDを取得する。
        //if (isset($_GET['category_id'])) {
        //    $arrCategoryId = $objDb->sfGetCategoryId('', $_GET['category_id']);
        //    if (!SC_Utils_Ex::isBlank($arrCategoryId)) {
        //        $TopicPath = $objDb->sfGetTopicPath2($arrCategoryId[0]);
        //        $this->tpl_topicpath = $TopicPath;
        //        //$this->assign('tpl_topicpath', $TopicPath); // 多分、こうしたかったんだろうなぁ... というイメージ
        //    }
        //}

        // ヘッダとフッタを割り当て
        $templatePath = SC_Helper_PageLayout_Ex::getTemplatePath($device_type_id);
        $header_tpl = $templatePath . 'header.tpl';
        //if ($_SERVER['REQUEST_URI'] == "/" || $_SERVER['REQUEST_URI'] == "/index.php") {
        //    $header_tpl = $templatePath . 'header_top.tpl';
        //} else {
        //    $header_tpl = $templatePath . 'header.tpl';
        //}
        $footer_tpl = $templatePath . 'footer.tpl';

        $this->assign('header_tpl', $header_tpl);
        $this->assign('footer_tpl', $footer_tpl);
    }
}
