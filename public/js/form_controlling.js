(function () {

	var LANGUAGE = location.pathname.split("/")[1];

	var btn = $("#sendFormBtn");
	var form = $("#registerForm");

	var params = {
		email : {
			el : $("#inputEmail"),
			isReady : false,
			pattern : /^\w+@\w+\.\w+$/i,
			messages : {
				ru : {
					error : "Введите корректный email",
					default : "Email",
				},
				en : {
					error : "Enter correct email",
					default : "Email",
				},
			}
		},
		nickname : {
			el : $("#inputNickname"),
			isReady : false,
			pattern : /^\w{5,30}$/i,
			messages : {
				ru : {
					error : "Длина от 5 до 30, разрешены английские символы, цифры и знак нижнего подчёркивания",
					default : "Никнейм",
				},
				en : {
					error : "The nickname's length should have from 5 to 30 characters, english characters, digitals and underscore are allowed",
					default : "Nickname",
				},
			}
		},
		password : {
			el : $("#inputPassword"),
			isReady : false,
			pattern : /^\w{7,35}$/i,
			messages : {
				ru : {
					error : "Длина пароля от 7 до 35, разрешены английские символы, цифры и знак нижнего подчёркивания",
					default : "Пароль",
				},
				en : {
					error : "The password's length should have from 7 to 35 characters, english characters, digitals and underscore are allowed",
					default : "Password",
				},
			}
		},
		confirmPassword : {
			el : $("#inputConfirmPassword"),
			isReady : false,
			pattern : function() {
				return $("#inputPassword").val();
			},
			messages : {
				ru : {
					error : "Пароли должны совпадать",
					default : "Подтвердить пароль",
				},
				en : {
					error : "The passwords should be equal",
					default : "Confirm password",
				},
			}
		},
		file : {
			el : $("#inputFile"),
			isReady : false,
			pattern : /[\.png|\.jpg|\.jpeg|\.gif]$/i,
			messages : {
				ru : {
					error : "Разрешены изобаржения формата .png .jpg .jpeg .gif",
					default : "Ваш аватар",
				},
				en : {
					error : "The .png .jpg .jpeg .gif formats are allowed",
					default : "Your avatar",
				},
			}
		}
	}

	var observer = {
		fields : params,

		checkAccess : function () {
			var flag = true;
			for(var key in this.fields) {
				if(!this.fields[key].isReady) {
					flag = false;
					break;
				};
			};

			if (flag) {
				this.allowAccess();
			} else {
				this.forbidAccess();
			};
		},

		allowAccess : function () {
			$("div[role=alert]").hide();
			btn.removeClass("disabled");
		},

		forbidAccess : function  () {
			$("div[role=alert]").show();
			btn.addClass("disabled");
	 	},

		bindInputEvents: function() {
			var self = this;
			for(var key in this.fields) {
				var field = this.fields[key];
				
				function makeCallback (obj) {
					var warnMsg = obj.messages[LANGUAGE].error;
					var sucMsg = obj.messages[LANGUAGE].default;
					return function (e) {
						obj.isReady = checkInput(obj.el, obj.pattern, warnMsg, sucMsg);
						self.checkAccess();
					};
				};

				if(field.el[0].type === "file") {
					var cb = makeCallback(field);
					$(field.el.selector).on("change", cb);
					cb();
					continue;
				}
				var cb = makeCallback(field);
				$(field.el.selector).on("input", makeCallback(field));
				cb();
			};
		}
	};

	/**
	 * Производит валидацию полей.В качестве паттерна может быть передано либо
	 * регулярное выражение либо функция. Если передана функция то значение
	 * поля сравнивается с возвращаемым значением функции
	 * 
	 * @param  {Object} 			el     
	 * @param  {Object|Function} 	pattern
	 * @param  {String} 			warnMsg
	 * @param  {String} 			sucMsg 
	 * @return {Bool}        
	 */
	function checkInput (el, pattern, warnMsg, sucMsg) {
		if (el.val() === "") {
			el.parent().removeClass('has-error');
			el.parent().removeClass('has-success');
			el.siblings().html(sucMsg);
			return false;
		};

		var flag = false;
		if (typeof(pattern) === "function") {
			flag = (el.val() === pattern());
		} else {
			if (el.val().search(pattern) === -1) {
				flag = false;
			} else {
				flag = true;
			}			
		};

		if(!flag) {
			el.parent().addClass('has-error');
			el.siblings().html(warnMsg);
			return false;
		} else {
			el.parent().removeClass('has-error');
			el.parent().addClass('has-success');
			el.siblings().html(sucMsg);
			return true;
		};
	}
	
	/**
	 * Дополнительный обработчик
	 * если поле пароля поменялось, то перепроверить поле подтеверждения пароля
	 */
	params.password.el.on("input", function(e) {
		params.confirmPassword.isReady = checkInput(
			params.confirmPassword.el,
			params.confirmPassword.pattern,
			params.confirmPassword.messages[LANGUAGE].error,
			params.confirmPassword.messages[LANGUAGE].default
		);
		observer.checkAccess();
	});

	observer.bindInputEvents();

	btn.click(function () {
		form.submit();
	});

}());