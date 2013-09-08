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

<div id="under02column">
    <div id="under02column_login">
        <h2 class="title">
            <img width="700" height="40" alt="ログイン" src="<!--{$TPL_URLPATH}-->img/login/title.jpg">
        </h2>
        <form onsubmit="return fnCheckLogin('login_mypage')" action="<!--{$smarty.const.HTTPS_URL}-->frontparts/login_check.php" method="post" id="login_mypage" name="login_mypage">
        <input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
        <input type="hidden" name="mode" value="login" />
        <input type="hidden" name="url" value="<!--{$smarty.server.REQUEST_URI|h}-->" />
            <div class="login_area">
                <p><img width="202" height="16" alt="会員登録がお済みのお客様" src="<!--{$TPL_URLPATH}-->img/login/member.gif"></p>
                <p class="inputtext">会員の方は、登録時に入力されたメールアドレスとパスワードでログインしてください。</p>
                <div class="inputbox">
                    <p>
                        <span class="attention"></span>
                        <img width="92" height="13" alt="メールアドレス" src="<!--{$TPL_URLPATH}-->img/login/mailadress.gif">&nbsp;
                        <input type="text" class="box300" size="40" style="; ime-mode: disabled;" maxlength="" value="" name="login_email">
                    </p>
                    <p class="mini">
                        <span class="attention"></span>
                        <input type="checkbox" id="login_memory" value="1" name="mypage_login_memory">
                        <label for="login_memory">会員メールアドレスをコンピューターに記憶させる</label>
                    </p>
                    <p class="passwd">
                        <span class="attention"></span>
                        <img width="92" height="13" alt="パスワード" src="<!--{$TPL_URLPATH}-->img/login/password.gif">
                        &nbsp;<input type="password" class="box300" size="40" style="" maxlength="" name="login_pass">
                    </p>
                </div>
                <div class="btn_area">
                    <input type="image" class="box140" id="log" name="log" alt="ログイン" src="<!--{$TPL_URLPATH}-->img/login/b_login.gif" onmouseout="chgImgImageSubmit('<!--{$TPL_URLPATH}-->img/login/b_login.gif',this)" onmouseover="chgImgImageSubmit('<!--{$TPL_URLPATH}-->img/login/b_login_on.gif',this)">
                </div>
                <p class="inputtext02">
                パスワードを忘れた方は<a target="_blank" onclick="win01('<!--{$smarty.const.HTTPS_URL}-->forgot/index.php','forget','600','400'); return false;" href="<!--{$smarty.const.HTTPS_URL}-->forgot/index.php">こちら</a>からパスワードの再発行を行ってください。<br>
                メールアドレスを忘れた方は、お手数ですが、<a href="<!--{$smarty.const.HTTP_URL}-->contact/index.php">お問い合わせページ</a>からお問い合わせください。
                </p>
            </div>
            <div class="login_area yetbloc">
                <p>
                    <img width="247" height="16" alt="まだ会員登録されていないお客様" src="<!--{$TPL_URLPATH}-->img/login/guest.gif">
                </p>
                <p class="inputtext">会員登録をすると便利なMyページをご利用いただけます。<br>
                また、ログインするだけで、毎回お名前や住所などを入力することなくスムーズにお買い物をお楽しみいただけます。
                </p>
                <div class="inputbox02">
                    <a onmouseout="chgImg('<!--{$TPL_URLPATH}-->img/login/b_gotoentry.gif','b_gotoentry');" onmouseover="chgImg('<!--{$TPL_URLPATH}-->img/login/b_gotoentry_on.gif','b_gotoentry');" href="/entry/kiyaku.php">
                    <img width="130" height="30" border="0" name="b_gotoentry" alt="会員登録をする" src="<!--{$TPL_URLPATH}-->img/login/b_gotoentry.gif"></a>
                </div>
            </div>
        </form>
    </div>
</div>
