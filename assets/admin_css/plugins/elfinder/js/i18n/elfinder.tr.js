/**
 * Turkish translation
 * @author Özgür Çakırca <dijitalartist@gmail.com>
 * @author Mesut Erdemir <erdemirmesut@gmail.com>
 * @version 2010-11-03
 */
(function($) {
if (elFinder && elFinder.prototype.options && elFinder.prototype.options.i18n) 
	elFinder.prototype.options.i18n.tr = {
		/* errors */
		'Root directory does not exists'       : 'Kök dizin mevcut değil',
		'Unable to connect to backend'         : 'Sunucu bağlantısı kurulamadı',
		'Access denied'                        : 'Giriş engellendi',
		'Invalid backend configuration'        : 'Geçersiz sunucu yapılandırması',
		'Unknown command'                      : 'Bilinmeyen komut',
		'Command not allowed'                  : 'Bu komut izin verilmiyor',
		'Invalid parameters'                   : 'Geçersiz parametreler',
		'File not found'                       : 'Dosya bulunamadı',
		'Invalid name'                         : 'Geçersiz isim',
		'File or folder with the same name already exists' : 'Dosya veya aynı adı taşıyan klasör zaten var',
		'Unable to rename file'                : 'Dosya yeniden adlandırılamıyor',
		'Unable to create folder'              : 'Klasör oluşturulamıyor',
		'Unable to create file'                : 'Dosya oluşturulamıyor',  
		'No file to upload'                    : 'Dosya yüklenemiyor',
		'Select at least one file to upload'   : 'Yüklemek için en az bir dosyayı seçin',
		'File exceeds the maximum allowed filesize' : 'Dosyası maksimum dosya boyutu aşıyor',
		'Not allowed file type'                 : 'Bu dosya tipine izin verilmiyor',
		'Unable to upload file'                 : 'Dosya yüklemek için açılamıyor',
		'Unable to upload files'                : 'Dosyalar yüklemek için açılamıyor',
		'Unable to remove file'                 : 'Dosya kaldırılamıyor',
		'Unable to save uploaded file'          : 'Yüklenen dosya kaydedilemiyor',
		'Some files was not uploaded'           : 'Bazı dosyalar yüklenemedi',
		'Unable to copy into itself'            : 'Kendi içindeki dosyalar kopyalanamıyor',
		'Unable to move files'                  : 'Dosyalar taşınamıyor',
		'Unable to copy files'                  : 'Dosyalar kopyalanamıyor',
		'Unable to create file copy'            : 'Kopyalanan dosya oluşturulamıyor',
		'File is not an image'                  : 'Bu resim dosyası değildir',
		'Unable to resize image'                : 'Resmi yeniden boyutlandırmak için açılamıyor',
		'Unable to write to file'               : 'Dosya yazılamıyor',
		'Unable to create archive'              : 'Arşiv oluşturulamadı',
		'Unable to extract files from archive'  : 'Arşiv dosyaları ayıklanamadı',
		'Unable to open broken link'            : 'Kırık link açılamıyor',
		'File URL disabled by connector config' : 'Bağlantı dosyası devre dışı',
		/* statusbar */
		'items'          : 'nesneler',
		'selected items' : 'Seçilen nesneleri',
		/* commands/buttons */
		'Back'                    : 'Geri',
		'Reload'                  : 'Yenile',
		'Open'                    : 'Aç',
		'Preview with Quick Look' : 'Hızlı görünüm',
		'Select file'             : 'Dosyayı seçin',
		'New folder'              : 'Yeni klasör',
		'New text file'           : 'Yeni metin dosyası',
		'Upload files'            : 'Dosya yükle',
		'Copy'                    : 'Kopyala',
		'Cut'                     : 'Kes',
		'Paste'                   : 'Yapıştır',
		'Duplicate'               : 'Aynısından Çoğalt',
		'Remove'                  : 'Kaldır',
		'Rename'                  : 'Yeniden adlandır',
		'Edit text file'          : 'Metin dosyasını düzenle',
		'View as icons'           : 'Simge Görünümü',
		'View as list'            : 'Liste Görünümü',
		'Resize image'            : 'Resmi yeniden boyutlandır',
		'Create archive'          : 'Arşiv yarat',
		'Uncompress archive'      : 'Arşivi aç',
		'Get info'                : 'Bilgi',
		'Help'                    : 'Yardım',
		'Dock/undock filemanger window' : 'Kilitle/Kilidi kaldır dosya yöneticisinin',
		/* upload/get info dialogs */
		'Maximum allowed files size' : 'Maksimum dosya boyutu',
		'Add field'   : 'Alan ekle',
		'File info'   : 'Dosya Özellikleri',
		'Folder info' : 'Klasör Özellikleri',
		'Name'        : 'Ad',
		'Kind'        : 'Türü',
		'Size'        : 'Boyut',
		'Modified'    : 'Değiştirme',
		'Permissions' : 'Erişim',
		'Link to'     : 'Bağlantı',
		'Dimensions'  : 'Boyutlar',
		'Confirmation required' : 'Onay gerekli',
		'Are you sure you want to remove files?<br /> This cannot be undone!' : 'Dosyayı silmek istediğinizden emin misiniz? <br /> eylem geri döndürülemez',
		/* permissions */
		'read'        : 'okuma',
		'write'       : 'yazma',
		'remove'      : 'kaldırma',
		/* dates */
		'Jan'         : 'Ocak',
		'Feb'         : 'Şubat',
		'Mar'         : 'Mart',
		'Apr'         : 'Nisan',
		'May'         : 'Mayıs',
		'Jun'         : 'Haziran',
		'Jul'         : 'Temmuz',
		'Aug'         : 'Ağustos',
		'Sep'         : 'Eylül',
		'Oct'         : 'Ekim',
		'Nov'         : 'Kasım',
		'Dec'         : 'Aralık',
		'Today'       : 'Bugün',
		'Yesterday'   : 'Dün',
		/* mimetypes */
		'Unknown'                           : 'Bilinmeyen',
		'Folder'                            : 'Klasör',
		'Alias'                             : 'Bağlantı',
		'Broken alias'                      : 'Kırık bağlantı',
		'Plain text'                        : 'Düz metin',
		'Postscript document'               : 'Postscript belge',
		'Application'                       : 'Uygulama',
		'Microsoft Office document'         : 'Microsoft Office belgesi',
		'Microsoft Word document'           : 'Microsoft Word belgesi',  
		'Microsoft Excel document'          : 'Microsoft Office Excel belgesi',
		'Microsoft Powerpoint presentation' : 'Microsoft Office Powerpoint belgesi',
		'Open Office document'              : 'Open Office belgesi',
		'Flash application'                 : 'Flash uygulaması',
		'XML document'                      : 'XML belgesi',
		'Bittorrent file'                   : 'Bittorrent dosyası',
		'7z archive'                        : '7z Arşiv',
		'TAR archive'                       : 'TAR Arşiv',
		'GZIP archive'                      : 'GZIP Arşiv',
		'BZIP archive'                      : 'BZIP Arşiv',
		'ZIP archive'                       : 'ZIP Arşiv',
		'RAR archive'                       : 'RAR Arşiv',
		'Javascript application'            : 'Javascript uygulaması',
		'PHP source'                        : 'PHP kaynak',
		'HTML document'                     : 'HTML belgesi',
		'Javascript source'                 : 'Javascript kaynak',
		'CSS style sheet'                   : 'CSS stil belgesi',
		'C source'                          : 'C kaynak',
		'C++ source'                        : 'C++ kaynak',
		'Unix shell script'                 : 'Unix shell script',
		'Python source'                     : 'Python kaynak',
		'Java source'                       : 'Java kaynak',
		'Ruby source'                       : 'Ruby kaynak',
		'Perl script'                       : 'Perl script',
		'BMP image'                         : 'BMP resim',
		'JPEG image'                        : 'JPEG resim',
		'GIF Image'                         : 'GIF resim',
		'PNG Image'                         : 'PNG resim',
		'TIFF image'                        : 'TIFF resim',
		'TGA image'                         : 'TGA resim',
		'Adobe Photoshop image'             : 'Adobe Photoshop resim',
		'MPEG audio'                        : 'MPEG ses',
		'MIDI audio'                        : 'MIDI ses',
		'Ogg Vorbis audio'                  : 'Ogg Vorbis ses',
		'MP4 audio'                         : 'MP4 ses',
		'WAV audio'                         : 'WAV ses',
		'DV video'                          : 'DV video',
		'MP4 video'                         : 'MP4 video',
		'MPEG video'                        : 'MPEG video',
		'AVI video'                         : 'AVI video',
		'Quicktime video'                   : 'Quicktime video',
		'WM video'                          : 'WM video ',
		'Flash video'                       : 'Flash video',
		'Matroska video'                    : 'Matroska video',
		// 'Shortcuts' : 'Клавиши',		
		'Select all files' : 'Tüm dosyaları seç',
		'Copy/Cut/Paste files' : 'Dosyaları Kopyala/Kes/Yapıştır',
		'Open selected file/folder' : 'Seçilen dosya/klasörü aç',
		'Open/close QuickLook window' : 'hızlı gözatı aç/kapa',
		'Remove selected files' : 'Seçilen dosyaları kaldır',
		'Selected files or current directory info' : 'Seçilen dosyalar veya dizin bilgisi',
		'Create new directory' : 'Yeni klasör yarat',
		'Open upload files form' : 'Dosya yükleme formunu aç',
		'Select previous file' : 'Önceki dosyayı seç',
		'Select next file' : 'Sonraki dosyayı seç',
		'Return into previous folder' : 'Bir önceki klasöre dön',
		'Increase/decrease files selection' : 'Dosyaları seç',
		'Authors'                       : 'Yazarlar',
		'Sponsors'  : 'Sponsors',
		'elFinder: Web file manager'    : 'elFinder: Web dosya yöneticisi',
		'Version'                       : 'Sürüm',
		'Copyright: Studio 42 LTD'      : 'Telif hakkı: Studio 42 LTD',
		'Donate to support project development' : 'Proje geliştirimine bağış için',
		'Javascripts/PHP programming: Dmitry (dio) Levashov, dio@std42.ru' : 'Javascripts/PHP programcısı: Dmitry (dio) Levashov, dio@std42.ru',
		'Python programming, techsupport: Troex Nevelin, troex@fury.scancode.ru' : 'Python programlama, teknik destek: Troex Nevelin, troex@fury.scancode.ru',
		'Design: Valentin Razumnih'     : 'Tasarım: Valentin Razumnih',
		'Spanish localization'          : 'İspanyolca yerelleştirme',
		'Icons' : 'iconlar',
		'License: BSD License'          : 'Lisans: BSD License',
		'elFinder documentation'        : 'elFinder belgeler',
		'Simple and usefull Content Management System' : 'Basit kullanışlı ve İçerik Yönetim Sistemi',
		'Support project development and we will place here info about you' : 'Support project development and we will place here info about you',
		'Contacts us if you need help integrating elFinder in you products' : 'Contacts us if you need help integrating elFinder in you products',
		'helpText' : 'elFinder bilgisayarınızdaki Dosya Yöneticisine benzer çalışır. <br /> üst çubuğu, menü veya klavye kısayol düğmeleri kullanarak dosyalarını işlemek. Basitçe, dosya / klasör taşımak istediğinizde klasör simgesini taşımak için kullanabilirsiniz.<br/>ElFinder aşağıdaki klavye kısayollarını destekler:'
		
	};
	
})(jQuery);
