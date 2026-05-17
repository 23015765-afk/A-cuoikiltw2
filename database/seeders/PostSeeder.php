<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $users      = User::where('role', 'user')->get();
        $categories = Category::all();

        $posts = [
            [
                'title'    => 'Kinh nghiệm du lịch Hội An 3 ngày 2 đêm tự túc',
                'location' => 'Hội An, Quảng Nam',
                'category' => 'Kinh nghiệm du lịch',
                'content'  => '<p>Hội An là một trong những điểm đến hấp dẫn nhất miền Trung Việt Nam. Phố cổ với những ngôi nhà mang kiến trúc Á Đông đặc trưng, đèn lồng rực rỡ và ẩm thực phong phú sẽ khiến bạn không muốn rời đi.</p>

<h3>Ngày 1: Khám phá Phố Cổ</h3>
<p>Buổi sáng, hãy đến thăm Chùa Cầu — biểu tượng của Hội An. Cây cầu này được xây dựng từ thế kỷ 17 và là di tích lịch sử quan trọng nhất của phố cổ. Tiếp theo, ghé thăm Hội quán Phúc Kiến, một trong những hội quán đẹp nhất tại đây.</p>
<p>Buổi chiều, đi dạo dọc bờ sông Thu Bồn, ngắm nhìn những con thuyền gỗ truyền thống và thưởng thức cà phê tại các quán ven sông.</p>

<h3>Ngày 2: Làng gốm Thanh Hà & Rừng Dừa</h3>
<p>Thuê xe đạp và khám phá Làng gốm Thanh Hà — nơi nghề gốm được lưu giữ từ 500 năm trước. Chiều, đến Rừng Dừa Bảy Mẫu để chèo thuyền thúng, một trải nghiệm độc đáo chỉ có ở Hội An.</p>

<h3>Ngày 3: Cù Lao Chàm</h3>
<p>Đặt tour đi Cù Lao Chàm — hòn đảo nhỏ xinh đẹp cách Hội An 18km. Lặn ngắm san hô, bơi lội ở bãi biển trong xanh và thưởng thức hải sản tươi ngon.</p>

<h3>Chi phí ước tính</h3>
<ul>
<li>Khách sạn: 300.000 - 500.000đ/đêm</li>
<li>Ăn uống: 150.000 - 200.000đ/ngày</li>
<li>Di chuyển: 50.000 - 100.000đ/ngày</li>
<li>Vé tham quan: 120.000đ/vé tham quan phố cổ</li>
</ul>',
                'status'   => 'published',
                'views'    => rand(100, 1000),
            ],
            [
                'title'    => 'Top 10 món ăn nhất định phải thử khi đến Đà Nẵng',
                'location' => 'Đà Nẵng',
                'category' => 'Ẩm thực',
                'content'  => '<p>Đà Nẵng không chỉ nổi tiếng với những bãi biển đẹp mà còn là thiên đường ẩm thực với vô vàn món ăn đặc sản hấp dẫn.</p>

<h3>1. Mì Quảng</h3>
<p>Đây là món ăn đặc trưng nhất của người dân miền Trung. Với sợi mì vàng to bản, nước lèo ít nhưng đậm đà, kết hợp với thịt heo, tôm, trứng cút và rau sống.</p>

<h3>2. Bánh mì Đà Nẵng</h3>
<p>Bánh mì Đà Nẵng nổi tiếng với vỏ bánh giòn, ruột bánh mềm và nhân phong phú. Đừng quên ghé bánh mì Bà Lan trên đường Nguyễn Chí Thanh.</p>

<h3>3. Bún chả cá</h3>
<p>Khác với bún chả miền Bắc, bún chả cá Đà Nẵng dùng chả cá thu thơm ngon, ăn kèm với rau muống và bún tươi trong nước lèo trong vắt.</p>

<h3>4. Bánh tráng cuốn thịt heo</h3>
<p>Đây là món không thể thiếu khi đến Đà Nẵng. Bánh tráng mỏng cuốn với thịt heo ba chỉ luộc, rau thơm, dưa leo và chấm mắm nêm.</p>

<h3>Địa chỉ ăn uống gợi ý</h3>
<ul>
<li>Mì Quảng Bà Mua — 19 Trần Bình Trọng</li>
<li>Bánh mì Bà Lan — Nguyễn Chí Thanh</li>
<li>Bún chả cá 109 — 109 Nguyễn Chí Thanh</li>
</ul>',
                'status'   => 'published',
                'views'    => rand(100, 1000),
            ],
            [
                'title'    => 'Review khách sạn Vinpearl Phú Quốc — Có đáng tiền không?',
                'location' => 'Phú Quốc, Kiên Giang',
                'category' => 'Khách sạn & Lưu trú',
                'content'  => '<p>Vinpearl Phú Quốc là resort 5 sao nằm trên bãi biển dài và đẹp nhất Phú Quốc. Sau chuyến nghỉ dưỡng 4 ngày 3 đêm, mình xin chia sẻ đánh giá chi tiết.</p>

<h3>Phòng nghỉ</h3>
<p>Chúng mình đặt phòng Superior Sea View với giá khoảng 3.500.000đ/đêm (đã bao gồm bữa sáng). Phòng rộng rãi khoảng 45m2, view nhìn ra biển tuyệt đẹp, nội thất hiện đại và sạch sẽ.</p>

<h3>Ẩm thực</h3>
<p>Bữa sáng buffet có hơn 50 món đa dạng từ Á đến Âu. Nhà hàng tối có menu phong phú tuy nhiên giá khá cao (dao động 300.000 - 800.000đ/món).</p>

<h3>Tiện ích</h3>
<ul>
<li>Hồ bơi vô cực nhìn ra biển: Tuyệt vời!</li>
<li>Bãi biển riêng: Sạch, không đông người</li>
<li>Khu vui chơi trẻ em: Rất phong phú</li>
<li>Spa: Dịch vụ tốt nhưng giá cao</li>
</ul>

<h3>Đánh giá tổng thể: 4.5/5</h3>
<p>Vinpearl Phú Quốc xứng đáng là lựa chọn hàng đầu cho kỳ nghỉ gia đình hoặc trăng mật. Mức giá cao nhưng chất lượng dịch vụ tương xứng.</p>',
                'status'   => 'published',
                'views'    => rand(100, 1000),
            ],
            [
                'title'    => 'Khám phá Sa Pa mùa lúa chín — Đẹp đến ngỡ ngàng',
                'location' => 'Sa Pa, Lào Cai',
                'category' => 'Địa điểm đẹp',
                'content'  => '<p>Tháng 9-10 là mùa lúa chín ở Sa Pa — thời điểm đẹp nhất trong năm khi những thửa ruộng bậc thang chuyển sang màu vàng óng ả.</p>

<h3>Bản Cát Cát</h3>
<p>Cách thị trấn Sa Pa khoảng 2km, bản Cát Cát là điểm tham quan đầu tiên không thể bỏ qua. Đây là làng người H\'Mông cổ với những ngôi nhà truyền thống và thác nước đẹp.</p>

<h3>Ruộng bậc thang Mù Cang Chải</h3>
<p>Nếu có thêm thời gian, hãy di chuyển sang Mù Cang Chải (Yên Bái) — nơi có những thửa ruộng bậc thang đẹp nhất Việt Nam. Đường đi khó nhưng hoàn toàn xứng đáng.</p>

<h3>Kinh nghiệm đi Sa Pa mùa lúa chín</h3>
<ul>
<li>Thời điểm: Cuối tháng 9 đến giữa tháng 10</li>
<li>Phương tiện: Tàu hỏa từ Hà Nội hoặc xe khách giường nằm</li>
<li>Nên thuê hướng dẫn viên người bản địa để đi trekking</li>
<li>Mang theo áo mưa và giày leo núi</li>
</ul>',
                'status'   => 'published',
                'views'    => rand(100, 1000),
            ],
            [
                'title'    => 'Hành trình phượt xuyên Tây Nguyên 7 ngày bằng xe máy',
                'location' => 'Tây Nguyên',
                'category' => 'Phượt',
                'content'  => '<p>Chuyến phượt xuyên Tây Nguyên từ Pleiku qua Kon Tum, Đắk Lắk đến Lâm Đồng là một trong những hành trình xe máy ấn tượng nhất mình từng thực hiện.</p>

<h3>Lịch trình 7 ngày</h3>
<p><strong>Ngày 1:</strong> Pleiku → Biển Hồ T\'Nưng → Thác Phú Cường<br>
<strong>Ngày 2:</strong> Pleiku → Kon Tum → Nhà thờ Gỗ<br>
<strong>Ngày 3:</strong> Kon Tum → Đắk Glei → Đắk Tô<br>
<strong>Ngày 4:</strong> Đắk Tô → Buôn Ma Thuột → Hồ Lắk<br>
<strong>Ngày 5:</strong> Buôn Ma Thuột → Bảo Lộc → Thác Đambri<br>
<strong>Ngày 6:</strong> Bảo Lộc → Đà Lạt<br>
<strong>Ngày 7:</strong> Khám phá Đà Lạt</p>

<h3>Lưu ý quan trọng</h3>
<ul>
<li>Xe máy nên kiểm tra kỹ trước khi đi</li>
<li>Xăng ở vùng sâu có thể khan hiếm, mang theo can xăng dự phòng</li>
<li>Đường núi nhiều đoạn hẹp và dốc, lái xe cẩn thận</li>
<li>Mang theo thuốc sơ cứu và áo mưa</li>
</ul>',
                'status'   => 'published',
                'views'    => rand(100, 1000),
            ],
        ];

        foreach ($posts as $postData) {
            $categoryName = $postData['category'];
            $category     = $categories->where('name', $categoryName)->first();
            $user         = $users->random();

            unset($postData['category']);

            Post::create([
                ...$postData,
                'user_id'      => $user->id,
                'category_id'  => $category->id,
                'excerpt'      => Str::limit(strip_tags($postData['content']), 200),
                'published_at' => now()->subDays(rand(1, 30)),
            ]);
        }
    }
}
