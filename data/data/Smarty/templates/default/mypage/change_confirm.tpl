<!--{*
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
*}-->

<div id="mypagecolumn">
    <h2 class="title"><img src="<!--{$TPL_URLPATH}-->img/mypage/title.jpg" width="700" height="40" alt="MYページ" /></h2>
    <!--{include file=$tpl_navi}-->
    <div id="mycontents_area">
        <h3><img src="<!--{$TPL_URLPATH}-->img/mypage/subtitle02.gif" width="515" height="32" alt="会員登録内容変更" /></h3>
        <p>下記の内容で送信してもよろしいでしょうか？<br />
            よろしければ、一番下の「送信」ボタンをクリックしてください。</p>
        <form name="form1" id="form1" method="post" action="?">
        <input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
        <input type="hidden" name="mode" value="complete" />
        <input type="hidden" name="customer_id" value="<!--{$arrForm.customer_id|h}-->" />
        <!--{foreach from=$arrForm key=key item=item}-->
            <!--{if $key ne "mode" && $key ne "subm"}-->
            <input type="hidden" name="<!--{$key|h}-->" value="<!--{$item|h}-->" />
            <!--{/if}-->
        <!--{/foreach}-->
        <table summary=" " class="delivname">
            <col width="30%" />
            <col width="70%" />
            <tr>
                <th>お名前<span class="attention">※</span></th>
                <td><!--{$arrForm.name01|h}-->　<!--{$arrForm.name02|h}--></td>
            </tr>
            <tr>
                <th>お名前（フリガナ）<span class="attention">※</span></th>
                <td><!--{$arrForm.kana01|h}-->　<!--{$arrForm.kana02|h}--></td>
            </tr>
            <tr>
                <th>郵便番号<span class="attention">※</span></th>
                <td><!--{$arrForm.zip01}-->-<!--{$arrForm.zip02}--></td>
            </tr>
            <tr>
                <th>住所<span class="attention">※</span></th>
                <td><!--{$arrPref[$arrForm.pref]}--><!--{$arrForm.addr01|h}--><!--{$arrForm.addr02|h}--></td>
            </tr>
            <tr>
                <th>電話番号<span class="attention">※</span></th>
                <td><!--{$arrForm.tel01|h}-->-<!--{$arrForm.tel02}-->-<!--{$arrForm.tel03}--></td>
            </tr>
            <tr>
                <th>ケータイ番号</th>
                <td><!--{if strlen($arrForm.fax01) > 0}--><!--{$arrForm.fax01}-->-<!--{$arrForm.fax02}-->-<!--{$arrForm.fax03}--><!--{else}-->未登録<!--{/if}--></td>
            </tr>
            <tr>
                <th>メールアドレス<span class="attention">※</span></th>
                <td><a href="<!--{$arrForm.email|escape:'hex'}-->"><!--{$arrForm.email|escape:'hexentity'}--></a></td>
            </tr>
            <tr>
                <th>ケータイメールアドレス</th>
                <td>
                    <!--{if strlen($arrForm.email_mobile) > 0}-->
                    <a href="<!--{$arrForm.email_mobile|escape:'hex'}-->"><!--{$arrForm.email_mobile|escape:'hexentity'}--></a>
                    <!--{else}-->
                    未登録
                    <!--{/if}-->
                </td>
            </tr>
            <tr>
                <th>性別<span class="attention">※</span></th>
                <td><!--{$arrSex[$arrForm.sex]}--></td>
            </tr>
            <tr>
                <th>職業</th>
                <td><!--{$arrJob[$arrForm.job]|default:"未登録"|h}--></td>
            </tr>
            <tr>
                <th>生年月日</th>
                <td><!--{if strlen($arrForm.year) > 0 && strlen($arrForm.month) > 0 && strlen($arrForm.day) > 0}--><!--{$arrForm.year|h}-->年<!--{$arrForm.month|h}-->月<!--{$arrForm.day|h}-->日<!--{else}-->未登録<!--{/if}--></td>
            </tr>
            <tr>
                <th>希望するパスワード<br />
                    <span class="mini">パスワードは購入時に必要です</span>
                </th>
                <td><!--{$passlen}--></td>
            </tr>
            <tr>
                <th>パスワードを忘れた時のヒント<span class="attention">※</span></th>
                <td>質問：&nbsp;<!--{$arrReminder[$arrForm.reminder]|h}--><br />
                        答え：&nbsp;<!--{$arrForm.reminder_answer|h}--></td>
            </tr>
            <tr>
                <th>メールマガジン送付について<span class="attention">※</span></th>
                <td><!--{$arrMAILMAGATYPE[$arrForm.mailmaga_flg]}--></td>
            </tr>
        </table>

        <div class="btn_area">
            <a href="?" onclick="fnModeSubmit('return', '', ''); return false;" onmouseover="chgImg('<!--{$TPL_URLPATH}-->img/common/b_back_on.gif','back');" onmouseout="chgImg('<!--{$TPL_URLPATH}-->img/common/b_back.gif','back');"><img src="<!--{$TPL_URLPATH}-->img/common/b_back.gif" alt="戻る" name="back" id="back" /></a>&nbsp;&nbsp;
            <input type="image" onmouseover="chgImgImageSubmit('<!--{$TPL_URLPATH}-->img/common/b_send.gif',this)" onmouseout="chgImgImageSubmit('<!--{$TPL_URLPATH}-->img/common/b_send.gif',this)" src="<!--{$TPL_URLPATH}-->img/common/b_send.gif" alt="送信" name="complete" id="complete" />
        </div>
        </form>
    </div>
</div>
