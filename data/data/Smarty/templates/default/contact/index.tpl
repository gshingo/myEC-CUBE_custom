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
<!--▼CONTENTS-->
<div id="undercolumn">
  <div id="undercolumn_contact">
    <h2 class="title"><img src="<!--{$TPL_URLPATH}-->img/contact/title.jpg" width="710" height="40" alt="お問い合わせ" /></h2>
    <p>お問い合わせはメールにて承っています。<br />
    内容によっては回答をさしあげるのにお時間をいただくこともございます。また、土日、祝祭日、年末年始、夏季期間は翌営業日以降の対応となりますのでご了承ください。</p>
    <p class="mini contact"><em>※ご注文に関するお問い合わせには、必ず「ご注文番号」と「お名前」をご記入の上、メールくださいますようお願いいたします。</em></p>
    <form name="form1" method="post" action="?">
    <input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
    <input type="hidden" name="mode" value="confirm" />
    <table id="contact_tbl" summary="お問い合わせ">
      <tr>
        <th>お名前<span class="attention">※</span></th>
        <td>
          <!--{if $arrErr.name01 != "" }-->
              <span class="attention"><!--{$arrErr.name01}--></span>
          <!--{/if}-->
          <!--{if $arrErr.name02 != "" }-->
              <span class="attention"><!--{$arrErr.name02}--></span>
          <!--{/if}-->
          姓&nbsp;<input type="text" class="box120" name="name01" value="<!--{$arrForm.name01.value|default:$arrData.name01|h}-->" maxlength="<!--{$smarty.const.STEXT_LEN}-->" style="<!--{$arrErr.name01|sfGetErrorColor}-->" />　
          名&nbsp;<input type="text" class="box120" name="name02" value="<!--{$arrForm.name02.value|default:$arrData.name02|h}-->" maxlength="<!--{$smarty.const.STEXT_LEN}-->" style="<!--{$arrErr.name02|sfGetErrorColor}-->" />
        </td>
      </tr>
      <tr>
        <th>お名前（フリガナ）<span class="attention">※</span></th>
        <td>
          <!--{if $arrErr.kana01 != "" }-->
              <span class="attention"><!--{$arrErr.kana01}--></span>
          <!--{/if}-->
          <!--{if $arrErr.kana02 != "" }-->
              <span class="attention"><!--{$arrErr.kana02}--></span>
          <!--{/if}-->
          セイ&nbsp;<input type="text" class="box120" name="kana01" value="<!--{$arrForm.kana01.value|default:$arrData.kana01|h}-->" maxlength="<!--{$smarty.const.STEXT_LEN}-->" style="<!--{$arrErr.kana01|sfGetErrorColor}-->" />　
          メイ&nbsp;<input type="text" class="box120" name="kana02" value="<!--{$arrForm.kana02.value|default:$arrData.kana02|h}-->" maxlength="<!--{$smarty.const.STEXT_LEN}-->" style="<!--{$arrErr.kana02|sfGetErrorColor}-->" />
        </td>
      </tr>
      <tr>
        <th>郵便番号</th>
        <td>
          <!--{if $arrErr.zip01 != "" }-->
              <span class="attention"><!--{$arrErr.zip01}--></span>
          <!--{/if}-->
          <!--{if $arrErr.zip02 != "" }-->
              <span class="attention"><!--{$arrErr.zip02}--></span>
          <!--{/if}-->
          <p>
            〒&nbsp;
            <input type="text" name="zip01" class="box60" value="<!--{$arrForm.zip01.value|default:$arrData.zip01|h}-->" maxlength="<!--{$smarty.const.ZIP01_LEN}-->" style="<!--{$arrErr.zip01|sfGetErrorColor}-->" />&nbsp;-&nbsp;
            <input type="text" name="zip02" class="box60" value="<!--{$arrForm.zip02.value|default:$arrData.zip02|h}-->" maxlength="<!--{$smarty.const.ZIP02_LEN}-->" style="<!--{$arrErr.zip02|sfGetErrorColor}-->" />　
            <a href="http://search.post.japanpost.jp/zipcode/" target="_blank"><span class="fs10">郵便番号検索</span></a>
          </p>
          <p class="zipimg">
            <a href="javascript:fnCallAddress('<!--{$smarty.const.URL_INPUT_ZIP}-->', 'zip01', 'zip02', 'pref', 'addr01');">
              <img src="<!--{$TPL_URLPATH}-->img/common/address.gif" width="86" height="20" alt="住所自動入力" /></a>
            <span class="mini autoadress">&nbsp;郵便番号を入力後、クリックしてください。</span>
          </p>
        </td>
      </tr>
      <tr>
        <th>住所</th>
        <td>
          <!--{if $arrErr.pref != "" }-->
              <span class="attention"><!--{$arrErr.pref}--></span>
          <!--{/if}-->
          <!--{if $arrErr.addr01 != "" }-->
              <span class="attention"><!--{$arrErr.addr01}--></span>
          <!--{/if}-->
          <!--{if $arrErr.addr02 != "" }-->
              <span class="attention"><!--{$arrErr.addr02}--></span>
          <!--{/if}-->
          <select name="pref" style="<!--{$arrErr.pref|sfGetErrorColor}-->">
          <option value="">都道府県を選択</option>
          <!--{html_options options=$arrPref selected=$pref.value|default:$arrData.pref|h}-->
          </select>
          <p class="mini">
            <input type="text" class="box380" name="addr01" value="<!--{$arrForm.addr01.value|default:$arrData.addr01|h}-->" style="<!--{$arrErr.addr01|sfGetErrorColor}-->" /><br />
            <!--{$smarty.const.SAMPLE_ADDRESS1}-->
          </p>
          <p class="mini">
            <input type="text" class="box380" name="addr02" value="<!--{$arrForm.addr02.value|default:$arrData.addr02|h}-->" style="<!--{$arrErr.addr02|sfGetErrorColor}-->" /><br />
            <!--{$smarty.const.SAMPLE_ADDRESS2}-->
          </p>
          <p class="mini"><em>住所は2つに分けてご記入いただけます。マンション名は必ず記入してください。</em></p>
        </td>
      </tr>
      <tr>
        <th>電話番号</th>
        <td>
          <!--{if $arrErr.tel01 != "" }-->
              <span class="attention"><!--{$arrErr.tel01}--></span>
          <!--{/if}-->
          <!--{if $arrErr.tel02 != "" }-->
              <span class="attention"><!--{$arrErr.tel02}--></span>
          <!--{/if}-->
          <!--{if $arrErr.tel03 != "" }-->
              <span class="attention"><!--{$arrErr.tel03}--></span>
          <!--{/if}-->
          <input type="text" class="box60" name="tel01" value="<!--{$arrForm.tel01.value|default:$arrData.tel01|h}-->" maxlength="<!--{$smarty.const.TEL_ITEM_LEN}-->" style="<!--{$arrErr.tel01|sfGetErrorColor}-->" />&nbsp;-&nbsp;
          <input type="text" class="box60" name="tel02" value="<!--{$arrForm.tel02.value|default:$arrData.tel02|h}-->" maxlength="<!--{$smarty.const.TEL_ITEM_LEN}-->" style="<!--{$arrErr.tel02|sfGetErrorColor}-->" />&nbsp;-&nbsp;
          <input type="text" class="box60" name="tel03" value="<!--{$arrForm.tel03.value|default:$arrData.tel03|h}-->" maxlength="<!--{$smarty.const.TEL_ITEM_LEN}-->" style="<!--{$arrErr.tel03|sfGetErrorColor}-->" />
        </td>
      </tr>
      <tr>
        <th>メールアドレス<span class="attention">※</span></th>
        <td>
          <!--{if $arrErr.email != "" }-->
              <span class="attention"><!--{$arrErr.email}--></span>
          <!--{/if}-->
          <!--{if $arrErr.email02 != "" }-->
              <span class="attention"><!--{$arrErr.email02}--></span>
          <!--{/if}-->
          <input type="text" class="box380" name="email" value="<!--{$arrForm.email.value|default:$arrData.email|h}-->" maxlength="<!--{$smarty.const.MTEXT_LEN}-->" style="<!--{$arrErr.email|sfGetErrorColor}-->" /><br />
          <!--{* ログインしていれば入力済みにする *}-->
          <!--{if $smarty.server.REQUEST_METHOD != 'POST' && $smarty.session.customer}-->
          <!--{assign var=email02 value=$arrData.email}-->
          <!--{/if}-->
          <!--{if $arrForm.email02.value != ''}-->
          <!--{assign var=email02 value=$arrForm.email02.value}-->
          <!--{/if}-->
          <input type="text" class="box380" name="email02" value="<!--{$email02|h}-->" maxlength="<!--{$smarty.const.MTEXT_LEN}-->" style="<!--{$arrErr.email02|sfGetErrorColor}-->" /><br />
          <p class="mini"><em>確認のため2度入力してください。</em></p>
        </td>
      </tr>
      <tr>
        <th>お問い合わせ内容<span class="attention">※</span><br />
        <span class="mini">（全角<!--{$smarty.const.MLTEXT_LEN}-->字以下）</span></th>
        <td>
          <!--{if $arrErr.contents != "" }-->
              <span class="attention"><!--{$arrErr.contents}--></span>
          <!--{/if}-->
          <textarea name="contents" class="area380" cols="60" rows="20" style="<!--{$arrErr.contents|sfGetErrorColor}-->"><!--{$contents|h}--></textarea>
        </td>
      </tr>
    </table>

    <div class="btn_area contact_btn">
      <input type="image" onmouseover="chgImgImageSubmit('<!--{$TPL_URLPATH}-->img/common/b_confirm_on.gif', this)" onmouseout="chgImgImageSubmit('<!--{$TPL_URLPATH}-->img/common/b_confirm.gif', this)" src="<!--{$TPL_URLPATH}-->img/common/b_confirm.gif" style="width:150px; height=30px;" alt="確認ページへ" name="confirm" />
    </div>
    </form>
  </div>
</div>
<!--▲CONTENTS-->
