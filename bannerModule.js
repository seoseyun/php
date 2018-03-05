/*
<ul class="클래스명">
</ul> <==
<ul class="클래스명">
</ul> <==
<li style="display:none;"
콘텐츠와 순서 부분의 ul의 순서는 상관없습니다.
콘텐츠와 순서부분의 ul은 나누어져있어야합니다.
해당 리스트의 li에는 인라인 스타일로 display를 줘야합니다.
ex) bannerModule.init('popnum','popcont','on','4000');
*/
	var bannerModule = (function(){
		var bannerNum = 0;
		var slideInterval ;
		var bannerCntClass ;
		var bannerContentClass ;
		var bannerOnClass ;
		var setIntervalTime ;
		var bannerContentBox ;
		var bannerNumBox ;

		/*
			ul의 클래싀 속의 li태그들을 가져오는것
		*/
		function getInnerLiTag(ulTagClass){
			return document.querySelectorAll("."+ulTagClass)[0].getElementsByTagName("li");
		}

		/*
			배너 슬라이드 동작
		*/
		function bannerSlide(bannerCnt,bannerContent,onClass){
			bannerContentBox = getInnerLiTag(bannerContent);
			bannerNumBox = getInnerLiTag(bannerCnt);

			for(var i = 0 ; i < bannerNumBox.length;i++){
				if(bannerNumBox[i].className == onClass){
					bannerNum = i+1;
					if(bannerNumBox.length <= bannerNum) bannerNum = 0;
				}
				bannerNumBox[i].className = "";
			}
			bannerNumBox[bannerNum].className=onClass
			for(var j = 0 ; j < bannerContentBox.length;j++){
				bannerContentBox[j].style.display="none";
			}
			bannerContentBox[bannerNum].style.display="block";
		}

		/*
			선택된 객체의 순서를 가져옴
		*/
		function getChildNumber(obj) {
			for(var i = 0 ; i < bannerNumBox.length;i++){
				if(obj.outerHTML == bannerNumBox[i].innerHTML){
					return i;
					break;
				}
			}
		}

		/*
			선택된 항목에 className을 줌.
		*/
		function selectedDisplay(selectedNum){
			bannerNum = selectedNum;
			for(var i = 0 ; i < bannerNumBox.length;i++){
				bannerNumBox[i].className = "";

			}
			bannerNumBox[bannerNum].className = bannerOnClass;
			for(var j = 0 ; j < bannerContentBox.length;j++){
				bannerContentBox[j].style.display="none";
			}
			bannerContentBox[bannerNum].style.display="block";
		}

		return {
			init : function(bannerCnt,bannerContent,onClass,setTime){
				bannerCntClass = bannerCnt;
				bannerContentClass = bannerContent;
				bannerOnClass = onClass;
				setIntervalTime = setTime;
				this.start();
				bannerSlide(bannerCntClass,bannerContentClass,bannerOnClass);
			},

			start : function(){
				this.stop();
				slideInterval = setInterval(function(){
					bannerSlide(bannerCntClass,bannerContentClass,bannerOnClass);
				},setIntervalTime)
			},

			stop : function(){
				clearInterval(slideInterval);
			},

			select : function(obj){
				this.stop();
				selectedDisplay(getChildNumber(obj));
				this.start();
			},

			next : function(){
				this.stop();
				bannerNum = bannerNum+1;
				if(bannerNumBox.length <= bannerNum) bannerNum = 0;
				selectedDisplay(bannerNum);
				this.start();
			},

			prev : function(){
				this.stop();
				bannerNum = bannerNum-1;
				if(bannerNum == "-1") bannerNum = (bannerNumBox.length - 1);
				selectedDisplay(bannerNum);
				this.start();
			}
		}
	})()
