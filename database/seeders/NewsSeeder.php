<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use Carbon\Carbon;

class NewsSeeder extends Seeder
{
    public function run()
    {
        $newsArticles = [
            [
                'title' => 'Global Technology Summit 2024 Announces Revolutionary AI Breakthrough',
                'slug' => 'global-technology-summit-2024-ai-breakthrough',
                'short_description' => 'Leading tech companies unveil groundbreaking artificial intelligence solutions that promise to transform industries worldwide.',
                'description' => '<p>The annual Global Technology Summit has concluded with remarkable announcements that are set to reshape the technological landscape. Major industry leaders presented innovative AI solutions that demonstrate unprecedented capabilities in machine learning, natural language processing, and automated decision-making.</p>

<p>Key highlights from the summit include:</p>
<ul>
<li>Advanced neural networks capable of real-time language translation</li>
<li>AI-powered healthcare diagnostics with 99% accuracy rates</li>
<li>Sustainable energy management systems using predictive algorithms</li>
<li>Revolutionary autonomous vehicle safety protocols</li>
</ul>

<p>Industry experts predict these innovations will create new job opportunities while transforming existing workflows across multiple sectors. The summit emphasized the importance of ethical AI development and responsible implementation of these powerful technologies.</p>

<p>Companies attending the summit reported significant investments in research and development, with combined funding exceeding $50 billion for the next fiscal year. This unprecedented commitment demonstrates the industry\'s confidence in AI\'s potential to solve complex global challenges.</p>',
                'images' => ['images/news/tech_summit_2024.jpg'],
                'status' => 'published',
                'is_featured' => true,
                'published_at' => Carbon::now()->subDays(1),
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ],
            [
                'title' => 'Sustainable Energy Initiative Reaches Major Milestone',
                'slug' => 'sustainable-energy-initiative-major-milestone',
                'short_description' => 'International renewable energy project achieves 75% clean energy adoption across participating nations.',
                'description' => '<p>The International Sustainable Energy Initiative has announced a significant achievement in its mission to promote clean energy adoption worldwide. The collaborative effort between 45 nations has successfully reached 75% renewable energy usage across participating countries.</p>

<p>This milestone represents years of coordinated efforts including:</p>
<ul>
<li>Installation of over 100,000 solar panel systems</li>
<li>Construction of 500 wind energy facilities</li>
<li>Development of advanced energy storage solutions</li>
<li>Implementation of smart grid technologies</li>
</ul>

<p>Environmental scientists report measurable improvements in air quality and significant reductions in carbon emissions. The initiative has also created over 2 million jobs in the renewable energy sector, contributing to economic growth while addressing climate change concerns.</p>

<p>Future plans include expanding the program to additional countries and investing in next-generation clean energy technologies such as hydrogen fuel cells and advanced geothermal systems.</p>',
                'images' => ['images/news/renewable_energy_2024.jpg'],
                'status' => 'published',
                'is_featured' => true,
                'published_at' => Carbon::now()->subDays(2),
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'title' => 'Medical Research Breakthrough: New Treatment Shows Promise',
                'slug' => 'medical-research-breakthrough-new-treatment',
                'short_description' => 'Clinical trials reveal promising results for innovative therapy targeting previously untreatable conditions.',
                'description' => '<p>Medical researchers at leading institutions have announced breakthrough results from Phase III clinical trials of a revolutionary treatment approach. The innovative therapy has shown remarkable success in treating conditions that were previously considered untreatable.</p>

<p>Key findings from the research include:</p>
<ul>
<li>85% improvement rate in patient outcomes</li>
<li>Minimal side effects compared to traditional treatments</li>
<li>Significant reduction in treatment duration</li>
<li>Cost-effective implementation potential</li>
</ul>

<p>The research team, comprising experts from multiple disciplines, utilized cutting-edge biotechnology and personalized medicine approaches. Their work represents a paradigm shift in treatment methodology and offers hope to millions of patients worldwide.</p>

<p>Regulatory approval processes are underway, with initial availability expected within the next 18 months. Healthcare systems are already preparing for implementation, with training programs being developed for medical professionals.</p>',
                'images' => ['images/news/medical_breakthrough_2024.jpg'],
                'status' => 'published',
                'is_featured' => false,
                'published_at' => Carbon::now()->subDays(3),
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'title' => 'Space Exploration Mission Discovers New Planetary System',
                'slug' => 'space-exploration-new-planetary-system',
                'short_description' => 'Advanced telescope technology reveals potentially habitable planets in distant solar system.',
                'description' => '<p>Space agencies have announced the discovery of a remarkable planetary system located 127 light-years from Earth. The system contains multiple planets, including several that appear to be within the habitable zone where liquid water could exist.</p>

<p>Mission highlights include:</p>
<ul>
<li>Discovery of 7 planets orbiting a sun-like star</li>
<li>3 planets within the habitable zone</li>
<li>Evidence of atmospheric composition suitable for life</li>
<li>Advanced spectroscopic analysis revealing water signatures</li>
</ul>

<p>The discovery was made possible through international collaboration and the deployment of next-generation space telescopes. Scientists are now planning follow-up missions to gather more detailed information about these potentially habitable worlds.</p>

<p>This finding represents one of the most significant astronomical discoveries in recent decades and opens new possibilities for understanding planetary formation and the potential for life beyond our solar system.</p>',
                'images' => ['images/news/space_discovery_2024.jpg'],
                'status' => 'published',
                'is_featured' => false,
                'published_at' => Carbon::now()->subDays(4),
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => Carbon::now()->subDays(4),
            ],
            [
                'title' => 'Economic Summit Addresses Global Trade Challenges',
                'slug' => 'economic-summit-global-trade-challenges',
                'short_description' => 'World leaders convene to discuss innovative solutions for international commerce and economic stability.',
                'description' => '<p>The World Economic Summit concluded with comprehensive agreements addressing current global trade challenges. Representatives from 60 nations participated in discussions focused on creating sustainable economic growth and addressing supply chain disruptions.</p>

<p>Summit outcomes include:</p>
<ul>
<li>New international trade agreements</li>
<li>Digital commerce standardization protocols</li>
<li>Supply chain resilience initiatives</li>
<li>Small business support programs</li>
</ul>

<p>Economic analysts predict these measures will help stabilize international markets and promote fair trade practices. The agreements emphasize sustainable development goals while supporting economic growth in developing nations.</p>

<p>Implementation of these initiatives is expected to begin within the next quarter, with monitoring systems established to track progress and effectiveness across participating countries.</p>',
                'images' => ['images/news/economic_summit_2024.jpg'],
                'status' => 'published',
                'is_featured' => false,
                'published_at' => Carbon::now()->subDays(5),
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'title' => 'Educational Innovation Program Transforms Learning Experience',
                'slug' => 'educational-innovation-program-transforms-learning',
                'short_description' => 'Revolutionary teaching methods and technology integration show remarkable improvements in student outcomes.',
                'description' => '<p>A comprehensive educational innovation program has demonstrated exceptional results in improving student learning outcomes across multiple institutions. The program combines advanced technology with proven pedagogical methods to create engaging and effective learning environments.</p>

<p>Program achievements include:</p>
<ul>
<li>40% improvement in student engagement rates</li>
<li>Enhanced critical thinking skill development</li>
<li>Personalized learning pathway implementation</li>
<li>Integration of virtual and augmented reality tools</li>
</ul>

<p>Educators report that students show increased motivation and better retention of complex concepts. The program\'s success has led to its adoption by educational institutions worldwide, with training programs being established for teachers and administrators.</p>

<p>Future developments include expansion to additional subject areas and the creation of adaptive learning systems that respond to individual student needs and learning styles.</p>',
                'images' => ['images/news/education_innovation_2024.jpg'],
                'status' => 'published',
                'is_featured' => false,
                'published_at' => Carbon::now()->subDays(6),
                'created_at' => Carbon::now()->subDays(6),
                'updated_at' => Carbon::now()->subDays(6),
            ]
        ];

        foreach ($newsArticles as $article) {
            News::create($article);
        }
    }
}