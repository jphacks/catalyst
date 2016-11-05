<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>*Catalyst</title>
		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<!-- base.css -->
		<link rel="stylesheet" type="text/css" href="css/index.css">
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body id="app">
		<div class="bs-docs-header">
			<div class="container">
				<h1>*Catalyst</h1>
				<p>単語と単語の化学反応を促進する触媒ウェブサービス</p>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="input-group input-group-lg">
					<input type="text" class="form-control" placeholder="気になる単語" aria-describedby="basic-addon1" v-model="word" @keyup.enter="onEnter">
					<div class="input-group-btn">
						<button type="button" class="btn btn-default" v-on:click="doSearch">調べる</button>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-4">
				<img alt="search word" src="img/search.gif" class="img-responsive">
				<h3>1. 調べる</h3>
				<p>あなたが行うことは単語を入力ことだけです．</p>
				<p>システムは自動でその単語と化学反応が起こりそうな単語候補をリストアップしてくれます．</p>
			</div>
			<div class="col-sm-4">
				<img alt="Responsive across devices" src="img/view.gif" class="img-responsive">
				<h3>2. 眺める</h3>
				<p>システムがリストアップした単語群を眺めます．</p>
				<p>気になる単語対はクリックすることで Google 検索の結果を見ることが出来ます．</p>
			</div>
			<div class="col-sm-4">
				<img alt="Components" src="img/idea.gif" style="height: 180px" class="img-responsive">
				<h3>3. 生み出す</h3>
				<p>あとはあなたの出番です．</p>
				<p>Enjoy!</p> 
			</div>
		</div>

		<div class="row">
			<p>Powered by <a href="https://radimrehurek.com/gensim/models/word2vec.html">word2vec</a>, <a href="http://taku910.github.io/mecab/">MeCab</a>, <a href="https://falconframework.org/">Falcon</a>, <a href="http://getbootstrap.com/">Bootstrap</a>.</p>

			<p>Code licensed <a href="https://github.com/twbs/bootstrap/blob/master/LICENSE" target="_blank" rel="license">MIT</a>, docs <a href="https://creativecommons.org/licenses/by/3.0/" target="_blank" rel="license">CC BY 3.0</a>.</p>
		</div>
		<!-- output start auth -->
		<div>
			<pre>
				<?php var_dump($user); ?>
			</pre>
			<img src="<?php echo $user['img'];?>"/>
		</div>
		<!-- output end auth -->
		<script src="js/jquery-3.1.0.min.js"></script>
		<script src="js/underscore.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/vue.js"></script>
		<script type="text/javascript">
		$(function() {
			new Vue({
				el: '#app',
				data: {
					// 検索単語
					word: ''
				},
				methods: {
					/**
					 * 検索単語入力時に <ENTER>
					 */
					onEnter: function(event) {
						this.redirect(this.word);
					},
					/**
					 * 検索ボタンが押された
					 */
					doSearch: function(event) {
						this.redirect(word);
					},
					/**
					 * /view に全てに任せる
					 */
					redirect: function(word) {
						if (word) {
							location.href = "view?word=" + word;
						} else {
							$("#word").focus();
						}
					}
				}
			});
		});
		</script>

	</body>
</html>