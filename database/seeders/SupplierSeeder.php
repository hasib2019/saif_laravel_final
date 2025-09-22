<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;
use Illuminate\Support\Str;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'GreenTech Solutions',
                'slug' => 'greentech-solutions',
                'short_description' => 'Leading provider of sustainable technology solutions for modern businesses.',
                'description' => 'GreenTech Solutions has been at the forefront of sustainable technology innovation for over 15 years. We specialize in developing eco-friendly solutions that help businesses reduce their carbon footprint while maintaining operational efficiency. Our comprehensive range of products includes solar energy systems, energy-efficient lighting, smart building automation, and waste management technologies. We are committed to creating a sustainable future through innovative technology and exceptional service.',
                'images' => json_encode([]),
                'pdf_file' => null,
                'video_file' => null,
                'youtube_link' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Industrial Manufacturing Corp',
                'slug' => 'industrial-manufacturing-corp',
                'short_description' => 'Trusted partner for high-quality industrial manufacturing and precision engineering.',
                'description' => 'Industrial Manufacturing Corp is a globally recognized leader in precision manufacturing and engineering solutions. With state-of-the-art facilities and a team of experienced engineers, we deliver high-quality components and systems for various industries including automotive, aerospace, and heavy machinery. Our commitment to quality, innovation, and customer satisfaction has made us a preferred supplier for Fortune 500 companies worldwide. We maintain ISO 9001:2015 certification and continuously invest in advanced manufacturing technologies.',
                'images' => json_encode([]),
                'pdf_file' => null,
                'video_file' => null,
                'youtube_link' => null,
                'sort_order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Digital Innovation Partners',
                'slug' => 'digital-innovation-partners',
                'short_description' => 'Cutting-edge digital transformation and software development services.',
                'description' => 'Digital Innovation Partners is a forward-thinking technology company specializing in digital transformation solutions. We help businesses modernize their operations through custom software development, cloud migration, artificial intelligence implementation, and digital strategy consulting. Our team of certified professionals has successfully delivered over 500 projects across various industries. We pride ourselves on staying ahead of technology trends and providing innovative solutions that drive business growth and operational efficiency.',
                'images' => json_encode([]),
                'pdf_file' => null,
                'video_file' => null,
                'youtube_link' => 'https://www.youtube.com/watch?v=M7lc1UVf-VE',
                'sort_order' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sustainable Materials Ltd',
                'slug' => 'sustainable-materials-ltd',
                'short_description' => 'Eco-friendly materials and sustainable packaging solutions for various industries.',
                'description' => 'Sustainable Materials Ltd is dedicated to providing environmentally responsible material solutions for businesses committed to sustainability. We offer a comprehensive range of biodegradable packaging, recycled materials, and eco-friendly alternatives to traditional industrial materials. Our research and development team continuously works on innovative sustainable materials that meet the highest quality standards while minimizing environmental impact. We serve clients in food packaging, construction, automotive, and consumer goods industries.',
                'images' => json_encode([]),
                'pdf_file' => null,
                'video_file' => null,
                'youtube_link' => null,
                'sort_order' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Advanced Logistics Systems',
                'slug' => 'advanced-logistics-systems',
                'short_description' => 'Comprehensive supply chain and logistics management solutions.',
                'description' => 'Advanced Logistics Systems provides end-to-end supply chain and logistics solutions designed to optimize efficiency and reduce costs. Our services include warehouse management, transportation coordination, inventory optimization, and supply chain analytics. With a network spanning multiple continents and advanced tracking technologies, we ensure reliable and timely delivery of goods. Our experienced team works closely with clients to develop customized logistics strategies that support their business objectives and enhance customer satisfaction.',
                'images' => json_encode([]),
                'pdf_file' => null,
                'video_file' => null,
                'youtube_link' => null,
                'sort_order' => 5,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Quality Assurance Experts',
                'slug' => 'quality-assurance-experts',
                'short_description' => 'Professional quality control and testing services for manufacturing industries.',
                'description' => 'Quality Assurance Experts is a leading provider of comprehensive quality control and testing services. We help manufacturers maintain the highest standards of product quality through rigorous testing protocols, quality management system implementation, and continuous improvement processes. Our certified laboratories are equipped with state-of-the-art testing equipment and staffed by experienced quality engineers. We serve clients in pharmaceuticals, food and beverage, automotive, electronics, and aerospace industries, ensuring compliance with international quality standards.',
                'images' => json_encode([]),
                'pdf_file' => null,
                'video_file' => null,
                'youtube_link' => null,
                'sort_order' => 6,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($suppliers as $supplierData) {
            Supplier::create($supplierData);
        }
    }
}
