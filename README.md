<!--- 画像URLの変数定義 --->
[ER図]: https://user-images.githubusercontent.com/81066421/120088010-a4574480-c127-11eb-97b6-e6b55492c6f7.png
[チェック]: https://user-images.githubusercontent.com/81066421/120052611-131d9a80-c061-11eb-9e86-f323d6cb2b41.png
[外部]: https://user-images.githubusercontent.com/81066421/120052614-13b63100-c061-11eb-8b16-a679f6241f26.png
[キー]: https://user-images.githubusercontent.com/81066421/120052616-144ec780-c061-11eb-9efc-0ab2224081ab.png


<!--- 本文はこちらから --->
# [ReadingRecoder](https://reading-recoder.herokuapp.com/)

## アプリ概要
書籍を検索して読書履歴を管理できるWEBアプリケーションです。
<br><br>

## 使用した技術
以下を使用してWEBアプリケーションを作成しました。
- **[Laravel](https://laravel.com/)**
- **[Laravel Valet](https://laravel.com/docs/8.x/valet/)**
- **[Vue.js](https://jp.vuejs.org/)**
- **[Vuetify](https://vuetifyjs.com/ja/)**
- **[Inertia.js](https://inertiajs.com/)**
- **[axios](https://axios-http.com/)**
- **[Google Books APIs](https://developers.google.com/books/)**
<br><br>

## URL一覧
URLの一覧は以下表の通りです。
| URL     | ルート名 | メソッド | 処理                                 |
|---------|----------|:--------:|--------------------------------------|
| /       | home     |    GET   | トップページを表示する。             |
| /search | search   |    GET   | 書籍検索ページを表示する。           |
| /form   | form     |    GET   | 書籍のコメント記入ページを表示する。 |
| /form   | form     |   POST   | 書籍のコメント記入処理を実行する。   |

<br><br>

## ER図
ER図は以下画像の通りです。

![ER図][ER図]
<br><br>

## テーブル定義
テーブル定義は以下表の通りです。
<br>

> ### booksテーブル
- 登録した書籍を管理します。

| カラム論理名 | カラム物理名 |      型      | PRIMARY | UNIQUE | NOT NULL | FOREIGN |
|--------------|--------------|:------------:|:-------:|:------:|:--------:|:-------:|
| 書籍ID       | id           | VARCHAR(255) |![キー][キー]|![チェック][チェック]|![チェック][チェック]|         |
| タイトル     | title        | VARCHAR(255) |         |        |![チェック][チェック]|         |
| 価格         | price        |    INTEGER   |         |        |          |         |
| 著者         | author       | VARCHAR(255) |         |        |          |         |
| 出版社       | publisher    | VARCHAR(255) |         |        |          |         |
| 発売日       | published    |     DATE     |         |        |          |         |
| 画像         | image        |     TEXT     |         |        |          |         |
| 作成日       | created_at   |   TIMESTAMP  |         |        |          |         |
| 更新日       | updated_at   |   TIMESTAMP  |         |        |          |         |

<br>

> ### commentsテーブル
- 書籍に対するコメントを管理します。

| カラム論理名 | カラム物理名 |      型      | PRIMARY | UNIQUE | NOT NULL |  FOREIGN  |
|--------------|--------------|:------------:|:-------:|:------:|:--------:|:---------:|
| コメントID   | id           | VARCHAR(255) |![キー][キー]|![チェック][チェック]|![チェック][チェック]|           |
| 書籍ID       | book_id      | VARCHAR(255) |         |        |![チェック][チェック]| ![外部][外部]&nbsp;books(id) |
| 読了日       | date         | VARCHAR(255) |         |        |![チェック][チェック]|           |
| コメント内容 | content      |   TIMESTAMP  |         |        |![チェック][チェック]|           |
| 作成日       | created_at   |   TIMESTAMP  |         |        |          |           |
| 更新日       | updated_at   |   TIMESTAMP  |         |        |          |           |

<br>




