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

	<script type="text/template" id="item">
		<% if (isFav) { %>
			<a href="https://www.google.co.jp/#newwindow=1&q=<%= word1 %>+<%= word2 %>" target="_blank" onclick="switchFav('<%= word1 %>', '<%= word2 %>')">
			<div class="col-md-4 item fav" id="<%= id %>">
				<p class="word1"><%= word1 %></p>
				<p class="text-center">x</p>
				<p class="word2"><%= word2 %></p>
			</div>
			</a>
		<% } else { %>
			<a href="https://www.google.co.jp/#newwindow=1&q=<%= word1 %>+<%= word2 %>" target="_blank" onclick="switchFav('<%= word1 %>', '<%= word2 %>')">
			<div class="col-md-4 item" id="<%= id %>">
				<p class="word1"><%= word1 %></p>
				<p class="text-center">x</p>
				<p class="word2"><%= word2 %></p>
			</div>
			</a>
		<% }%>
	</script>

	<script type="text/template" id="loading">
		<div class="col-md-4">
			<img src="img/progress.gif">      
		</div>
	</script>

	<script type="text/template" id="empty">
		<div class="col-md-4 item">
			<p>化学変化は起こりませんでした…</p>
			<p>別の単語で試してみてください．</p>
		</div>
	</script>
</head>
<body>
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
					<input type="text" class="form-control" placeholder="気になる単語" id="word">
					<button class="btn btn-default" id="search" onclick="return false;">調べる</button>
				</div>
			</form>
			<ul class="nav navbar-nav">
				<li><a href="<?php echo $this->html->url('/', true); ?>/like.html" class="w">Link</a></li>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
	</nav>
	<div class="row" id="wrapper">
		<!-- append child -->
		<div class="col-md-4">
			<img src="img/progress.gif">      
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
	<script type="text/javascript">
		$(function() {

			// クエリ取得
			var getQueryParams = function() {
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
			}

			/* ------------------------------------------------------- */
			// お気に入り登録関連
			// $.cookie.json = true;
			var keyFormat = function (word1, word2) {
				return word1+"_xxxx_"+word2;
			}
			var setFav = function(word1, word2) {
				$.cookie(keyFormat(word1, word2), 'true');
			}
			var unsetFav = function(word1, word2) {
				$.cookie(keyFormat(word1, word2), 'false');
			}
			var isFav = function(word1, word2) {
				if ($.cookie(keyFormat(word1, word2))) {
					return true;
				} else {
					return false;
				}
			}
			var switchFav = function(word1, word2) {
				console.log(word1);
				console.log(word2);
				if (isFav(word1, word2)) {
					unsetFav(word1, word2);
					$("#"+keyFormat(word1, word2)).removeClass("fav");
				} else {
					setFav(word1, word2);
					$("#"+keyFormat(word1, word2)).addClass("fav");
				}
			}
			// Global bridge
			window.switchFav = switchFav;
			window.isFav = isFav;
			/* ------------------------------------------------------- */

			// templater
			var item = _.template($("#item").html());
			var loading = _.template($("#loading").html());
			var empty = _.template($("#empty").html());

			// データ取得
			var fetchData = function(word) {
				$("#word").val(word);
				$("#wrapper").children().remove();
				$("#wrapper").append(loading());
				$.ajax({
					type: "GET",
					// dataType: "JSON",
					url: "/api_wvec?word=" + word,
				}).done(function(json) {
					var json = JSON.parse(json);
					$("#wrapper").children().fadeOut("fast", function() {
						$("#wrapper").children().remove();
						if (json.length == 0) {
							$("#wrapper").append(empty());
						}
						$.each(json, function(index, elem) {
							var compiled = item({
								word1: $("#word").val(),
								word2: elem[0],
								id: keyFormat($("#word").val(), elem[0]),
								isFav: isFav($("#word").val(), elem[0]),
							});
							$("#wrapper").append(compiled);
						});

						// 見栄え調整
						$(".word2").fitText();
					});
				});
			}

			// 初期ページロード時
			var word = getQueryParams()["word"];

			if (word) {
				fetchData(word);
			} else {
				location.href = "<?php echo $this->html->url('/', true); ?>/";
			}

			// 検索開始
			$("#word").on("keypress", function(e) {
				if (e.keyCode == 13) {
					console.log($(this).val());
					// fetchData($(this).val());
				}
			});

			// 検索開始
			$("#search").click(function() {
				// console.log($("#word").val());
				fetchData($("#word").val());
			});
		});
	</script>
</body>
</html>