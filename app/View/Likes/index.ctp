<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>*Catalyst</title>
	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/view.css" rel="stylesheet">

	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body id="app">
	<nav class="navbar navbar-default bs-docs-header">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo $this->html->url('/', true); ?>">*Catalyst</a>
		</div>

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<form class="navbar-form navbar-left">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="気になる単語" id="word" v-model="word" @keyup.enter="onEnter">
					<button class="btn btn-default" id="search" onclick="return false;" v-on:click="doSearch">調べる</button>
				</div>
			</form>
			<ul class="nav navbar-nav">
				<li><a href="<?php echo $this->html->url('/', true); ?>likes" class="w">Link</a></li>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
	</nav>
	<div class="row" id="wrapper">
		<ul>
			<li v-for="item in words">
				<a href="https://www.google.co.jp/#newwindow=1&q={{ item.word1 }}+{{ item.word2 }}" target="_blank" onclick="switchFav('<%= word1 %>', '<%= word2 %>')">
					<div class="col-md-4 item" id="<%= id %>">
						<p class="word1">{{ item.word1 }}</p>
						<p class="text-center">x</p>
						<p class="word2">{{ item.word2 }}</p>
					</div>
				</a>
			</li>
		</ul>
		<!-- append child -->
		<div class="col-md-4">
			<!-- <img src="img/progress.gif"> -->
		</div>
	</div>
	<div class="row">
	<p>Powered by <a href="https://radimrehurek.com/gensim/models/word2vec.html">word2vec</a>, <a href="http://taku910.github.io/mecab/">MeCab</a>, <a href="https://falconframework.org/">Falcon</a>, <a href="http://getbootstrap.com/">Bootstrap</a>.</p>

	<p>Code licensed <a href="https://github.com/twbs/bootstrap/blob/master/LICENSE" target="_blank" rel="license">MIT</a>, docs <a href="https://creativecommons.org/licenses/by/3.0/" target="_blank" rel="license">CC BY 3.0</a>.</p>
	</div>
	<script src="js/jquery-3.1.0.min.js"></script>
	<script src="js/underscore.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.fittext.js"></script>
	<script src="js/jquery.cookie-1.4.1.min.js"></script>
	<script src="js/vue.js"></script>
	<script type="text/javascript">
		$(function() {

			new Vue({
				el: '#app',
				data: {
					word: "",
					words: [],
					api: "/api_favorite?",
				},
				created: function() {
					this.fetchWordList();
				},
				methods: {
					/**
					 * GET パラメタ取得
					 */
					getQueryParams: function() {
						var result = {};
						if (1 < window.location.search.length) {
							var query = window.location.search.substring(1);
							var parameters = query.split("&");
							for (var i = 0; i < parameters.length; i++) {
								var element = parameters[i].split("=");
								var paramName = decodeURIComponent(element[0]);
								var paramValue = decodeURIComponent(element[1]);
								result[paramName] = paramValue;
							}
						}
						return result;
					},
					/**
					 * 単語対をサーバから取得する
					 */
					fetchWordList: function(word) {
						var url;
						if (word) {
							url = this.api + "word=" + word;
						} else {
							url = this.api;
						}
						$.ajax({
							type: "GET",
							url: url,
						}).done(function(json) {
							this.words = json.result;
						}.bind(this));
					},
					/**
					 * 単語リストを空にする
					 */
					emptyWordList: function() {
						this.words = [];
					},
					/**
					 * 検索ボタンが押された
					 */
					doSearch: function(event) {
						console.log(event);
						console.log(this.word);
						this.fetchWordList(this.word);
					},
					/**
					 * 検索単語入力時に <ENTER>
					 */
					onEnter: function(event) {
						console.log(event);
						console.log(this.word);
						this.fetchWordList(this.word);
					}
				}
			});
		});
	</script>
</body>
</html>