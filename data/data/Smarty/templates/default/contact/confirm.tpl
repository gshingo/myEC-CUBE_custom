<!--{*
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
 *}-->

<div id="undercolumn">
    <h2 class="title"><img src="<!--{$TPL_URLPATH}-->img/contact/title.jpg" width="710" height="40" alt="お問い合わせ" /></h2>
    <div id="undercolumn_contact">
        <p>下記入力内容で送信してもよろしいでしょうか？<br />
            よろしければ、一番下の「送信」ボタンをクリックしてください。</p>
        <form name="form1" id="form1" method="post" action="?">
        <input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
        <input type="hidden" name="mode" value="complete" />
        <!--{foreach key=key item=item from=$arrForm}-->
            <!--{if $key ne 'mode'}-->
                <input type="hidden" name="<!--{$key}-->" value="<!--{$item.value|h}-->" />
            <!--{/if}-->
        <!--{/foreach}-->
        <table id="contact_tbl" summary="お問い合わせ内容確認">
            <!--{*
            <col width="30%" />
            <col width="70%" />
            *}-->
            <tr>
                <th>お名前<span class="attention">※</span></th>
                <td><!--{$arrForm.name01.value|h}-->　<!--{$arrForm.name02.value|h}--></td>
            </tr>
            <tr>
                <th>お名前（フリガナ）<span class="attention">※</span></th>
                <td><!--{$arrForm.kana01.value|h}-->　<!--{$arrForm.kana02.value|h}--></td>
            </tr>
            <tr>
                <th>郵便番号</th>
                <td>
                    <!--{if strlen($arrForm.zip01.value) > 0 && strlen($arrForm.zip02.value) > 0}-->
                        〒<!--{$arrForm.zip01.value|h}-->-<!--{$arrForm.zip02.value|h}-->
                    <!--{/if}-->
                </td>
            </tr>
            <tr>
                <th>住所</th>
                <td><!--{$arrPref[$arrForm.pref.value]}--><!--{$arrForm.addr01.value|h}--><!--{$arrForm.addr02.value|h}--></td>
            </tr>
            <tr>
                <th>電話番号</th>
                <td>
                    <!--{if strlen($arrForm.tel01.value) > 0 && strlen($arrForm.tel02.value) > 0 && strlen($arrForm.tel03.value) > 0}-->
                        <!--{$arrForm.tel01.value|h}-->-<!--{$arrForm.tel02.value|h}-->-<!--{$arrForm.tel03.value|h}-->
                    <!--{/if}-->
                </td>
            </tr>
            <tr>
                <th>メールアドレス<span class="attention">※</span></th>
                <td><a href="mailto:<!--{$arrForm.email.value|escape:'hex'}-->"><!--{$arrForm.email.value|escape:'hexentity'}--></a></td>
            </tr>
            <tr>
                <th>お問い合わせ内容<span class="attention">※</span><br />
                    <span class="mini">（全角<!--{$smarty.const.MLTEXT_LEN}-->字以下）</span></th>
                <td><!--{$arrForm.contents.value|h|nl2br}--></td>
            </tr>
        </table>
        <div class="btn_area contact_btn">
            <a href="?" onclick="fnModeSubmit('return', '', ''); return false;" onmouseover="chgImg('<!--{$TPL_URLPATH}-->img/common/b_back_on.gif','back02');" onmouseout="chgImg('<!--{$TPL_URLPATH}-->img/common/b_back.gif','back02');"> <img src="<!--{$TPL_URLPATH}-->img/common/b_back.gif" alt="戻る" name="back02" id="back02" /></a>
            <input type="image" onmouseover="chgImgImageSubmit('<!--{$TPL_URLPATH}-->img/common/b_send_on.gif',this)" onmouseout="chgImgImageSubmit('<!--{$TPL_URLPATH}-->img/common/b_send.gif',this)" src="<!--{$TPL_URLPATH}-->img/common/b_send.gif" alt="送信" name="send" id="send" />
        </div>

        </form>
    </div>
</div>
