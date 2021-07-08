;
(function(global, factory) {
	"use strict";
	if (typeof module === "object" && typeof module.exports === "object") {
		module.exports = global.document ?
			factory(global, true) :
			function(w) {
				if (!w.document) {
					throw new Error("Page requires a window with a document");
				}
				return factory(w);
			};
	} else {
		factory(global);
	}
})(typeof window !== "undefined" ? window : this, function(window, noGlobal) {
	// var tiangan = ['甲', '乙', '丙', '丁', '戊', '己', '庚', '辛', '壬', '癸'];
	// var dizhi = ['子', '丑', '寅', '卯', '辰', '巳', '午', '未', '申', '酉', '戌', '亥'];
	// var shengxiao = ['鼠', '牛', '虎', '兔', '龙', '蛇', '马', '羊', '猴', '鸡', '狗', '猪'];


	// function CalculateYearGanZhi(year) {
	// 	// 2000年 庚辰龙年
	// 	var sc = year - 2000;
	// 	var gan = (6 + sc) % 10;
	// 	var zhi = (4 + sc) % 12;

	// 	if (gan < 0) {
	// 		gan += 10;
	// 	}
	// 	if (zhi < 0) {
	// 		zhi += 12;
	// 	}
	// 	return tiangan[gan] + dizhi[zhi] + shengxiao[zhi] + '年';
	// }
	var lunarInfo = new Array(
		0x04bd8, 0x04ae0, 0x0a570, 0x054d5, 0x0d260, 0x0d950, 0x16554, 0x056a0, 0x09ad0, 0x055d2,
		0x04ae0, 0x0a5b6, 0x0a4d0, 0x0d250, 0x1d255, 0x0b540, 0x0d6a0, 0x0ada2, 0x095b0, 0x14977,
		0x04970, 0x0a4b0, 0x0b4b5, 0x06a50, 0x06d40, 0x1ab54, 0x02b60, 0x09570, 0x052f2, 0x04970,
		0x06566, 0x0d4a0, 0x0ea50, 0x06e95, 0x05ad0, 0x02b60, 0x186e3, 0x092e0, 0x1c8d7, 0x0c950,
		0x0d4a0, 0x1d8a6, 0x0b550, 0x056a0, 0x1a5b4, 0x025d0, 0x092d0, 0x0d2b2, 0x0a950, 0x0b557,
		0x06ca0, 0x0b550, 0x15355, 0x04da0, 0x0a5d0, 0x14573, 0x052d0, 0x0a9a8, 0x0e950, 0x06aa0,
		0x0aea6, 0x0ab50, 0x04b60, 0x0aae4, 0x0a570, 0x05260, 0x0f263, 0x0d950, 0x05b57, 0x056a0,
		0x096d0, 0x04dd5, 0x04ad0, 0x0a4d0, 0x0d4d4, 0x0d250, 0x0d558, 0x0b540, 0x0b5a0, 0x195a6,
		0x095b0, 0x049b0, 0x0a974, 0x0a4b0, 0x0b27a, 0x06a50, 0x06d40, 0x0af46, 0x0ab60, 0x09570,
		0x04af5, 0x04970, 0x064b0, 0x074a3, 0x0ea50, 0x06b58, 0x055c0, 0x0ab60, 0x096d5, 0x092e0,
		0x0c960, 0x0d954, 0x0d4a0, 0x0da50, 0x07552, 0x056a0, 0x0abb7, 0x025d0, 0x092d0, 0x0cab5,
		0x0a950, 0x0b4a0, 0x0baa4, 0x0ad50, 0x055d9, 0x04ba0, 0x0a5b0, 0x15176, 0x052b0, 0x0a930,
		0x07954, 0x06aa0, 0x0ad50, 0x05b52, 0x04b60, 0x0a6e6, 0x0a4e0, 0x0d260, 0x0ea65, 0x0d530,
		0x05aa0, 0x076a3, 0x096d0, 0x04bd7, 0x04ad0, 0x0a4d0, 0x1d0b6, 0x0d250, 0x0d520, 0x0dd45,
		0x0b5a0, 0x056d0, 0x055b2, 0x049b0, 0x0a577, 0x0a4b0, 0x0aa50, 0x1b255, 0x06d20, 0x0ada0)
	var Animals = new Array("鼠", "牛", "虎", "兔", "龙", "蛇", "马", "羊", "猴", "鸡", "狗", "猪");
	var Gan = new Array("甲", "乙", "丙", "丁", "戊", "己", "庚", "辛", "壬", "癸");
	var Zhi = new Array("子", "丑", "寅", "卯", "辰", "巳", "午", "未", "申", "酉", "戌", "亥");
	var now = new Date();
	var SY = now.getFullYear();
	var SM = now.getMonth();
	var SD = now.getDate();


	function cyclical(num) {
		num = parseInt(num);
		// console.log(num--)
		return (Gan[num % 10] + Zhi[num % 12])
	} //==== 传入 offset 传回干支, 0=甲子
	//==== 传回农历 y年的总天数
	function lYearDays(y) {
		var i, sum = 348
		for (i = 0x8000; i > 0x8; i >>= 1) sum += (lunarInfo[y - 1900] & i) ? 1 : 0
		return (sum + leapDays(y))
	}

	//==== 传回农历 y年闰月的天数
	function leapDays(y) {
		if (leapMonth(y)) return ((lunarInfo[y - 1900] & 0x10000) ? 30 : 29)
		else return (0)
	}

	//==== 传回农历 y年闰哪个月 1-12 , 没闰传回 0
	function leapMonth(y) {
		return (lunarInfo[y - 1900] & 0xf)
	}

	//====================================== 传回农历 y年m月的总天数
	function monthDays(y, m) {
		return ((lunarInfo[y - 1900] & (0x10000 >> m)) ? 30 : 29)
	}

	//==== 算出农历, 传入日期物件, 传回农历日期物件
	//     该物件属性有 .year .month .day .isLeap .yearCyl .dayCyl .monCyl
	function Lunar(objDate) {
		var i, leap = 0,
			temp = 0
		var baseDate = new Date(1900, 0, 31)
		var offset = (objDate - baseDate) / 86400000

		this.dayCyl = offset + 40
		this.monCyl = 14

		for (i = 1900; i < 2050 && offset > 0; i++) {
			temp = lYearDays(i)
			offset -= temp
			this.monCyl += 12
		}
		if (offset < 0) {
			offset += temp;
			i--;
			this.monCyl -= 12
		}

		this.year = i
		this.yearCyl = i - 1864

		leap = leapMonth(i) //闰哪个月
		this.isLeap = false

		for (i = 1; i < 13 && offset > 0; i++) {
			//闰月
			if (leap > 0 && i == (leap + 1) && this.isLeap == false) {
				--i;
				this.isLeap = true;
				temp = leapDays(this.year);
			} else {
				temp = monthDays(this.year, i);
			}

			//解除闰月
			if (this.isLeap == true && i == (leap + 1)) this.isLeap = false

			offset -= temp
			if (this.isLeap == false) this.monCyl++
		}

		if (offset == 0 && leap > 0 && i == leap + 1)
			if (this.isLeap) {
				this.isLeap = false;
			}
		else {
			this.isLeap = true;
			--i;
			--this.monCyl;
		}

		if (offset < 0) {
			offset += temp;
			--i;
			--this.monCyl;
		}

		this.month = i
		this.day = offset + 1
	}


	//==== 中文日期
	function cDay(m, d) {
		d = parseInt(d);
		var nStr1 = new Array('日', '正', '二', '三', '四', '五', '六', '七', '八', '九', '十', '冬', '腊');
		var nStr2 = new Array('初', '十', '廿', '卅', '　');
		var nStr3 = new Array('日', '一', '二', '三', '四', '五', '六', '七', '八', '九', '十');
		var s;

		s = nStr1[m] + '月';

		switch (d) {
			case 10:
				s += '初十';
				break;
			case 20:
				s += '二十';
				break;
			case 30:
				s += '三十';
				break;
			default:
				s += nStr2[Math.floor(d / 10)];
				s += nStr3[d % 10];
		}
		return (s);
	}



	function solarDay(y, m, d) {
		var sDObj = new Date(y, m, d);
		var lDObj = new Lunar(sDObj);
		//农历BB'+(cld[d].isLeap?'闰 ':' ')+cld[d].lMonth+' 月 '+cld[d].lDay+' 日
		// var tt = cyclical(SY - 1900 + 36) + '年 ' + cDay(lDObj.month, lDObj.day);
		var tt = cDay(lDObj.month, lDObj.day);
		return tt;
	}

	function addZero(num) {
		num = String(num);
		if (num.length == 1) {
			num = 0 + num;
		}
		return num;
	}

	function DateJs(options) {
		options = options || {};
		this.inputEl = options.inputEl;
		this.el = options.el;
		this.input = null; //填充日期的input框
		this.div = 'div';
		this.dom = null; //日期选择器
		var now = new Date();
		this.today = {
			nowFullYear: now.getFullYear(), // 年份
			nowMonth: now.getMonth() + 1, // 月份
			nowDay: now.getDate(), // 几号
			nowDays: now.getDay(), // 星期几
			date: function() {
				return this.nowFullYear + '-' + this.nowMonth + '-' + this.nowDay;
			}
		}
		this.weeks = ['日', '一', '二', '三', '四', '五', '六'];

		this.yearDom = null;
		this.weekDom = null;
		this.monthDom = null;
		this.currectYear = this.today.nowFullYear; //当前选择的年份
		this.currectMonth = this.today.nowMonth; //当前选择的月份
		this.showDate = function() {
			return this.currectYear + '年' + addZero(this.currectMonth) + '月';
		}
		this.showFullDate = function(day) {
			return this.currectYear + '-' + addZero(this.currectMonth) + '-' + addZero(day);
		}
		this.choiceDateFn = function(day) {
			return this.currectYear + '-' + this.currectMonth + '-' + day;
		}
		this.choiceDate = {}; //选中的日期
		this.currectChoice = null; //选中的日期dom
		this.isShow = true; // 显示日期选择器
		this.todayDom = null; // 今天的日期dom
		this.showDateDom = null;
		this.init();

	}

	DateJs.prototype = {
		init: function() {
			this.initInput();
			this.initDomBox();
			this.initDom();

		},
		initInput: function() {
			var _this = this;
			this.input = document.querySelector(this.inputEl); //填充日期的input框
			this.parent = document.querySelector(this.el);
			this.dom = document.createElement(this.div); //日期选择器
			this.parent.appendChild(this.dom);
			if (!this.isShow) {
				this.dom.style.display = 'none';
			}
			this.input.addEventListener('focus', function(e) {
				_this.isShow = true;
				if (_this.isShow) {
					_this.dom.style.display = 'block';
				}
			});
			// document.addEventListener('click', function(e) {
			// 	var target = e.target;
			// 	if (target.parentNode == null) {
			// 		return;
			// 	}
			// 	while (target) {
			// 		if (target == _this.input || target == _this.dom) {
			// 			return;
			// 		}
			// 		target = target.parentNode;
			// 	}

			// 	_this.isShow = false;
			// 	if (!_this.isShow) {
			// 		_this.dom.style.display = 'none';
			// 	}
			// })

		},
		initDomBox: function() {
			var div = this.div;
			this.yearDom = document.createElement(div);
			this.weekDom = document.createElement(div);
			this.monthDom = document.createElement(div);
			this.monthDom.classList.add('show-month');
			this.btsDom = document.createElement(div);
			this.btsDom.classList.add('bts');
			this.dom.appendChild(this.yearDom);
			this.dom.appendChild(this.weekDom);
			this.dom.appendChild(this.monthDom);
			this.dom.appendChild(this.btsDom);
		},
		initDom: function() {
			this.dom.classList.add('date-js');
			this.renderYearDom();
			this.renderWeekDom();
			this.renderMonthDom();
			// this.initBtsDom();
		},
		// initBtsDom: function() {
		// 	var div = this.div;
		// 	var _this = this;
		// 	var now = document.createElement(div); //此刻
		// 	var sure = document.createElement(div);
		// 	now.classList.add('bt');
		// 	now.innerHTML = '今日';
		// 	now.addEventListener('click', function() {
		// 		_this.currectYear = _this.today.nowFullYear;
		// 		_this.currectMonth = _this.today.nowMonth;
		// 		_this.renderMonthDom(_this.showDateDom);
		// 		_this.showCurrectDate(_this.showDateDom);
		// 		if (_this.currectChoice) {
		// 			_this.currectChoice.classList.remove('active');
		// 		}
		// 		_this.currectChoice = _this.todayDom;
		// 		_this.currectChoice.classList.add('active');
		// 		var this_year = Number(_this.todayDom.getAttribute('data-year'));
		// 		var this_month = Number(_this.todayDom.getAttribute('data-month'));
		// 		var val = _this.todayDom.innerHTML;
		// 		_this.input.value = this_year + '-' + addZero(this_month) + '-' + addZero(val);
		// 		_this.choiceDate.date = this_year + '-' + addZero(this_month) + '-' + addZero(val);
		// 		_this.choiceDate.month = this_month;
		// 		_this.choiceDate.year = this_year;
		// 	});
		// 	sure.classList.add('bt');
		// 	sure.innerHTML = '确定';
		// 	sure.addEventListener('click', function() {
		// 		_this.isShow = false;
		// 		if (!_this.isShow) {
		// 			_this.dom.style.display = 'none';
		// 		}
		// 	});
		// 	this.btsDom.appendChild(now);
		// 	this.btsDom.appendChild(sure);
		// },
		showCurrectDate: function(dom) {
			dom.innerHTML = this.showDate();
			// var res = CalculateYearGanZhi(this.currectYear);
			// dom.title = res;
		},
		renderYearDom: function() {
			var div = this.div;
			var _this = this;
			var yearDom = this.yearDom;
			yearDom.classList.add('show-year');

			var showDate = this.showDateDom = document.createElement(div); //显示当前选中的年月
			showDate.classList.add('show-date');
			this.showCurrectDate(showDate);
			var prevYear = document.createElement(div); //上一年
			prevYear.innerHTML = '«';
			prevYear.classList.add('change-date');
			prevYear.addEventListener('click', function() {
				_this.currectYear--;
				_this.currectChoice = null;
				_this.renderMonthDom();
				_this.showCurrectDate(showDate);

			});
			var prevmonth = document.createElement(div); //上一月
			prevmonth.innerHTML = '<';
			prevmonth.classList.add('change-date');
			prevmonth.addEventListener('click', function() {
				_this.currectMonth--;
				_this.currectChoice = null;
				if (_this.currectMonth == 0) {
					_this.currectMonth = 12;
					_this.currectYear--;
				}
				_this.renderMonthDom();
				_this.showCurrectDate(showDate);
			});

			var nextYear = document.createElement(div); //下一年
			nextYear.innerHTML = '»';
			nextYear.classList.add('change-date');
			nextYear.addEventListener('click', function() {
				_this.currectYear++;
				_this.currectChoice = null;
				_this.renderMonthDom();
				_this.showCurrectDate(showDate);
			})
			var nextmonth = document.createElement(div); //下一月
			nextmonth.innerHTML = '>';
			nextmonth.classList.add('change-date');
			nextmonth.addEventListener('click', function() {
				_this.currectMonth++;
				_this.currectChoice = null;
				if (_this.currectMonth == 13) {
					_this.currectMonth = 1;
					_this.currectYear++;
				}
				_this.renderMonthDom();
				_this.showCurrectDate(showDate);
			});
			yearDom.appendChild(prevYear);
			yearDom.appendChild(prevmonth);
			yearDom.appendChild(showDate);
			yearDom.appendChild(nextmonth);
			yearDom.appendChild(nextYear);
		},
		renderWeekDom: function() {
			var div = this.div;
			var weekDom = this.weekDom;
			weekDom.classList.add('show-week');
			var weeks = this.weeks;
			var len = weeks.length;
			var fg = document.createDocumentFragment();
			for (var i = 0; i < len; i++) {
				var dayDom = document.createElement(div);
				dayDom.classList.add('week-day');
				dayDom.innerHTML = weeks[i];
				fg.appendChild(dayDom);
			}
			weekDom.appendChild(fg);
		},
		renderMonthDom: function(self) {
			var _this = this;
			var div = this.div;
			var monthDom = this.monthDom;
			var today = this.today;
			var currectYear = this.currectYear; //当前选择的年份
			var currectMonth = this.currectMonth; //当前选择的月份
			var showMonth = this.month(currectYear, currectMonth);
			var fg = document.createDocumentFragment();
			var len = showMonth.length;
			for (var i = 0; i < len; i++) {
				var item = document.createElement(div);
				item.innerHTML = showMonth[i].day;
				item.classList.add('month-day');
				if (showMonth[i].month != this.currectMonth || showMonth[i].year != this.currectYear) {
					item.classList.add('not-this-month');
				}
				var nongli = solarDay(showMonth[i].year, showMonth[i].month - 1, showMonth[i].day);
				item.title = nongli;
				if (showMonth[i].date == this.today.date()) {
					item.classList.add('today');
					item.classList.add('active');
				}
				item.setAttribute('data-month', showMonth[i].month);
				item.setAttribute('data-year', showMonth[i].year);
				if (showMonth[i].date == this.choiceDate.date && this.currectMonth == this.choiceDate.month && this.currectYear ==
					this.choiceDate.year) {
					item.classList.add('active');
					this.currectChoice = item;
				}
				if (showMonth[i].date == this.today.date()) {
					this.todayDom = item;
				}
				// 点击每一个日期
				item.addEventListener('click', function() {
					if (_this.currectChoice != null) {
						_this.currectChoice.classList.remove('active');
						_this.choiceDate = {};
					}
					// 点击的日期的年份
					var this_year = Number(this.getAttribute('data-year'));
					// 点击的日期的月份
					var this_month = Number(this.getAttribute('data-month'));
					// 获取具体日期
					var val = this.innerHTML;
					// 设置输入框的值
					_this.input.value = this_year + '-' + addZero(this_month) + '-' + addZero(val);
					// 更新choiceDate.date的值
					_this.choiceDate.date = this_year + '-' + addZero(this_month) + '-' + addZero(val);
					_this.choiceDate.month = this_month;
					_this.choiceDate.year = this_year;
					_this.currectChoice = this;
					this.classList.add('active');
					if (this_month != _this.currectMonth) {
						_this.currectMonth = this_month;
						_this.currectYear = this_year;
						_this.showCurrectDate(_this.showDateDom);
						_this.renderMonthDom(true);
					}
				})
				fg.appendChild(item);

			}
			monthDom.innerHTML = '';
			monthDom.appendChild(fg);
			if (self) {
				_this.dom.style.display = 'block';
			}

		},
		month: function(fullYear, month) {
			var allDays = new Date(fullYear, month, 0).getDate();
			var weeks = this.weeks;
			var showMonth = this.showMonth = [];
			var beforeDays = new Date(fullYear, month - 1, 1).getDay();
			beforeDays = beforeDays == 0 ? 7 : beforeDays;
			var lastDay = new Date(fullYear, month - 1, 0).getDate();
			var beginDay = lastDay - beforeDays + 1;
			// 上个月的几天补充进来
			var prevMonth;
			var prevYear;
			if (month - 1 <= 0) {
				prevMonth = 12;
				prevYear = fullYear - 1;
			} else {
				prevMonth = month - 1;
				prevYear = fullYear;
			}
			for (var i = beginDay; i <= lastDay; i++) {
				showMonth.push({
					year: prevYear,
					month: prevMonth,
					date: prevYear + '-' + prevMonth + '-' + i,
					day: i
				});
			}
			// 这个月的天数
			for (var i = 1; i <= allDays; i++) {
				var obj = {
					day: i,
					week: weeks[new Date(fullYear, month - 1, i).getDay()]
				}
				showMonth.push({
					year: fullYear,
					month: month,
					date: fullYear + '-' + month + '-' + i,
					day: i
				});
			}
			// 下个月的几天补充进来
			var nextMonth;
			var nextYear;
			if (month + 1 >= 13) {
				nextMonth = 1;
				nextYear = fullYear + 1;
			} else {
				nextMonth = month + 1;
				nextYear = fullYear;
			}
			var over = 7 * 6 - showMonth.length;
			for (var j = 1; j <= over; j++) {
				showMonth.push({
					year: nextYear,
					month: nextMonth,
					date: fullYear + '-' + nextMonth + '-' + j,
					day: j
				});
			}
			return showMonth;
		}
	}

	DateJs.prototype.constructor = DateJs;
	if (typeof noGlobal === "undefined") {
		window.DateJs = DateJs;
	}
	return DateJs;
})
