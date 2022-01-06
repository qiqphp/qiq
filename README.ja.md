# PHP8 Qiqテンプレート

このパッケージは、[TemplateView](http://martinfowler.com/eaaCatalog/templateView.html) と[TwoStepView](http://martinfowler.com/eaaCatalog/twoStepView.html) パターンをPHP8.0で実装したもので、PHPそのものをテンプレート言語として使用します。
オプションの`{{ ... }}`構文で、簡潔なエスケープとヘルパーを使用できます。

## 背景

私はコンパイルされたテンプレートや専用のテンプレート言語が好きではありません。[Smarty](https://github.com/smarty-php/smarty) や [Twig](https://github.com/twigphp/Twig) その他は、どれも強引すぎます。新しい言語は必要ありませんし、チームのデザイナーからテンプレートを「守る」必要もありません。私は、テンプレート言語としてプレーンなPHPに概ね満足しています。

しかし、私はエスケープが面倒だと感じています。エスケープされたHTMLを出力するテンプレートヘルパーは、このようなものです。

```
<?= $this->h($var) ?>
```

それほど悪くはないのですが、それでも、もう少し簡単にはできないものでしょうか。 想像してみてください。

ほんの少しのシンタックスシュガー
```
{{h $var }}
```

このとき起こることは、`{{h ... }}`が`<?= $this->h(...) ?>`に置き換わることだけです。

これができれば、ヘルパーや制御構造などのコードを簡単にサポートできるようになります。なぜなら`{{ ... }}`タグは本質的にPHPタグの代用品だからです。

Qiqは本当にPHPなのです -- 必要なときにだけ、シンタックスシュガーがあるんです。

## 由緒

Qiqの家族には

- Savant一族:
    - [Savant 1 and 2](https://github.com/pmjones/savant)
    - [Savant 3](https://github.com/saltybeagle/Savant3)
    - [PEAR Templates_Savant](https://github.com/pear2/Templates_Savant/)
    - [Savvy](https://github.com/saltybeagle/Savvy)
- [Solar_View](http://solarphp.com/manual/views)
- [Aura.View](http://auraphp.com/packages/2.x/View.html)
- [Laminas View](https://docs.laminas.dev/laminas-view/) (nee Zend_View)

このパッケージは、SavantのComposer以前のバージョンよりもAura.Viewに近いものですが、Savantコンパイラフックのアイデアを再導入しています。
