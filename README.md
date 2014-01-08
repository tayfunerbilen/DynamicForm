Ne işe yarar?
===========

Bu sınıf sizin için dinamik olarak sizin belirlediğiniz elemanlardan oluşan form oluşturur ve bu formdaki bilgileri bir dosyaya daha sonra kullanmanız için kayıt eder. Kısaca veritabanı olmadan basit web sayfalarınızı yönetilebilir hale getirmenizi sağlar.

Hangi form tiplerini destekler?
===========
Şuan sınıfı temel anlamda kullanabilirsiniz. İlk versiyon için kullanabileceğiniz form tipleri şunlardır;
- input [checkbox, radio ve button hariç]
- select [multiple]
- textarea


Nasıl kullanılır?
===========

İlk olarak sınıf dosyasını çağıralım.

```
require 'dynamicForm.class.php';
```

Ve sınıfı içerisine şu 3 parametreyi girerek başlatalım;

```
$form = new DynamicForm([
   'path' => realpath('.'),
   'variable' => 'ayarlar',
   'file' => 'ayarlar.php'
]);
```

Şimdi ise oluşturacağımız form elemanlarını dizi halinde metodda belirtelim.

```
$form->config([
    ['İletişim Bilgileri'],
    [
        'name' => 'eposta',
        'text' => 'E-posta Adresi',
        'desc' => 'Lütfen geçerli bir e-posta adresi girin!'
    ],
    [
        'name' => 'hakkinda',
        'text' => 'Hakkında',
        'field' => 'textarea'
    ],
    [
        'name' => 'kategori',
        'text' => 'Kategori',
        'field' => 'select',
        'options' => [
            ['value' => 'blog', 'text' => 'Blog'],
            ['value' => 'css', 'text' => 'Css Dersleri']
        ],
        'multiple' => true
    ]
]);
```

Artık bunu bir form içinde kullanıp elemanları oluşturabiliriz.

```
<form action="" method="post">
    <?php $form->create(); ?>
    <button type="submit" name="submit" value="kaydet">Kaydet
</form>
```

Bilgileri post ettirdiğimizde ise belirlediğimiz dosyaya dizi olarak kayıt ettirelim.

```
