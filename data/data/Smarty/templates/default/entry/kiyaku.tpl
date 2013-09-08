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
    <div id="undercolumn_entry">
        <h2 class="title"><img src="<!--{$TPL_URLPATH}-->img/entry/agree_title.jpg" width="710" height="40" alt="ご利用規約" /></h2>
        <p class="advice">【重要】 会員登録をされる前に、下記ご利用規約をよくお読みください。</p>
        <p>規約には、本サービスを使用するに当たってのあなたの権利と義務が規定されております。<br />
            「規約に同意して会員登録」ボタンをクリックすると、あなたが本規約の全ての条件に同意したことになります。
        </p>

        <form name="form1" id="form1" method="post" action="?">
        <input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
        <textarea name="textfield" class="kiyaku_text" cols="80" rows="30" readonly="readonly"><!--{$tpl_kiyaku_text|h}--></textarea>

        <div class="btn_area">
            <a href="<!--{$smarty.const.TOP_URLPATH}-->" onmouseover="chgImg('<!--{$TPL_URLPATH}-->img/entry/b_noagree_on.gif','b_noagree');" onmouseout="chgImg('<!--{$TPL_URLPATH}-->img/entry/b_noagree.gif','b_noagree');"><img src="<!--{$TPL_URLPATH}-->img/entry/b_noagree.gif" alt="同意しない" border="0" name="b_noagree" /></a>&nbsp;
            <a href="<!--{$smarty.const.ENTRY_URL}-->" onmouseover="chgImg('<!--{$TPL_URLPATH}-->img/entry/b_agree_on.gif','b_agree');" onmouseout="chgImg('<!--{$TPL_URLPATH}-->img/entry/b_agree.gif','b_agree');"><img src="<!--{$TPL_URLPATH}-->img/entry/b_agree.gif" alt="同意して会員登録へ" border="0" name="b_agree" /></a>
        </div>

        </form>
    </div>
</div>
