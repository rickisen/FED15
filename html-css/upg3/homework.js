// homework.js - ugly MVC-breaking hack. 
var homework = angular.module('homework',[]);
homework.controller('HomeworkController',function($scope) {
	function generate(a,b) {
		var list = [];
		var numBoxes = Math.floor(Math.random()*a+1);
		for(var i=0;i<numBoxes;i++) {
			var rnd = Math.floor(Math.random()*b+1);
			var str="";
			for(var j=0;j<rnd;j++)
				str = str + "bla bla ";
			
			list.push(str);
		}
		return list;
	}	
	$scope.redBoxes  = generate(4,6);
	$scope.darkGreenBoxes = generate(7,6);
	$scope.brownBox = generate(1,10)[0];
	$scope.limeBox = generate(1,70)[0];
	$scope.articles  = generate(5,200);
	var pics = ["https://upload.wikimedia.org/wikipedia/commons/thumb/3/32/Bucket_of_raw_okra_pods.jpg/220px-Bucket_of_raw_okra_pods.jpg","http://globalgamejam.org/sites/default/files/styles/game_sidebar__normal/public/game/featured_image/promo_5.png","http://www.kaiserfoods.com.sg/wp-content/uploads/2015/05/Pumpkin-Soup-300x300.jpg"];
	$scope.pic = pics[(Math.floor(Math.random()*3))];
	});
