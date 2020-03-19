<dialog id="wall-kagawa">
    <div class="msgbox" style="width: 750px;height: 500px">
        <div class="msgboxtop">確認</div>
        <div class="msgboxbody" style="text-align: center">
            <span style="font-size: 60px">&#x26a0;</span>
            <p style="font-size: 23px">あなたは香川県民ですか？</p>
            <hr>
            <p>{{ session('locale') . ' - ' . session('pref') }}</p>
            <p>
                当サイトは、香川県ネット・ゲーム依存症対策条例第11条各項に基づき、<br>
                香川県内からのアクセスはすべてお断りしています。<br>
                なお、この確認は当サイトが同条例に対し賛同を示すものではありません。
            </p>
            <p style="font-size: 13px;">
                This dialog is displayed based on the Kagawa Prefectural Internet and Game Addiction Measures Ordinance.<br>
                If you are not a Kagawa citizen, press "いいえ" to continue.
            </p>
            <div id="localStorageUnavailable">
                <hr>
                <p style="font-size: 14px;">
                    あなたの使用しているブラウザは何らかの理由でlocalStorageを利用できません。<br>
                    ページ遷移ごとにこの確認ダイアログが表示されます。<br>

                </p>
            </div>
        </div>
        <div class="msgboxfoot">
            <a href="javascript:enableWallKagawa()" class="button jw">はい</a>
            <a href="javascript:disableWallKagawa()" class="button jw">いいえ</a>
        </div>
    </div>
</dialog>
<style>
    dialog#wall-kagawa::backdrop, dialog#wall-kagawa + .backdrop{
        background: rgba(0,0,0,0.8);
    }
</style>

<script>
    /**
     * WebStorageAPI 使用可否検証関数
     * https://developer.mozilla.org/ja/docs/Web/API/Web_Storage_API/Using_the_Web_Storage_API
     * */
    function storageAvailable(type) {
        var storage;
        try {
            storage = window[type];
            var x = '__storage_test__';
            storage.setItem(x, x);
            storage.removeItem(x);
            return true;
        }
        catch(e) {
            return e instanceof DOMException && (
                // everything except Firefox
                e.code === 22 ||
                // Firefox
                e.code === 1014 ||
                // test name field too, because code might not be present
                // everything except Firefox
                e.name === 'QuotaExceededError' ||
                // Firefox
                e.name === 'NS_ERROR_DOM_QUOTA_REACHED') &&
                // acknowledge QuotaExceededError only if there's something already stored
                (storage && storage.length !== 0);
        }
    }

    const wallKagawa = document.getElementById('wall-kagawa');
    wallKagawa.addEventListener('cancel',function(event){
        event.preventDefault();
    });

    function disableWallKagawa(){
        localStorage.setItem('wallkagawa',false);
        wallKagawa.close();
        console.info('WallKagawa disabled!');
    }
    function enableWallKagawa(){
        localStorage.setItem('wallkagawa',true);
        location.href = location.href + '?pref=kagawa'
    }

    if(storageAvailable('localStorage')){
        console.info('localStorage available.');
        document.getElementById('localStorageUnavailable').setAttribute('style','display:none;');
    }

    if(localStorage.getItem('wallkagawa') !== "false"){
        wallKagawa.showModal();
    }else{
        console.info('WallKagawa is already disabled.');
    }


</script>