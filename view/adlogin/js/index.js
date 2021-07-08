
    /**
     * 获取验证码
     * 更新验证码
     * 登录事件
     * 重置事件
     * */
    let user_el = $("#user");
    let passwd_el = $("#psw");
    let code_el = $("#code");

    /**
     * 设置验证码
     * */
    function setCode() {
        $("#mycode").attr("src", "/php/model/code.php?c=" + new Date().getTime());
    }


    /**
     * 登录请求
     * */
    function login(user, passwd, code) {
        $.ajax({
            type: 'POST',
            url: '/php/api/login/v1.api.adlogin.php',
            data: {
                "adaccout": user,
                "adpsw": passwd,
                "captcha": code,
            },
            dataType: 'json'
        }).done(function (data) {
            // console.log(data);
            if(data.code==200)
            {
                window.location.href="/view/adhome"
            }else{
                alert(data.message);
                setCode();
            }
        }).fail(function (xhr, status) {
            console.log("检查失败了" + status + xhr);
        });
    }

    /**
     * 验证表单
     * */
    function checkval(user, passwd, code) {
        let reg = /^[^\s]*$/;
        let flag = false;
        if (!isEmptyOrBlank(user) && !isEmptyOrBlank(passwd) && !isEmptyOrBlank(code) && reg.test(user) && reg.test(passwd) && reg.test(code))
            flag = true;
        return flag;
    }
    /**
     * 判断是否为空
     * */
    function isEmptyOrBlank(str) {
        if (str == null || str.length == 0) {
            return true;
        } else {
            return false;
        }
    }

    function main() {
        /**
        * 点击验证码更新验证码
        * */
        $("#mycode").click(function () {
            setCode();
        })
        /**
         * 登录按钮
         * */
        $("#login").click(function () {
            let user = user_el.val().trim();
            let passwd = passwd_el.val().trim();
            let code = code_el.val().trim();

            // console.log(user);
            if (!checkval(user, passwd, code)) {
                alert("输入框不能为空或存在空格");
                setCode();
                return;
            }
            login(user, passwd, code);
        })
        /**
         * 重置按钮
         * */
        $("#reset").click(function () {
            user_el.val("");
            passwd_el.val("");
            code_el.val("");
            setCode()
        });
        setCode();
    }

    main();