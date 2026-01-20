<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Setting;
use Livewire\Component;

class WebsiteSettings extends Component
{
    public $home = [];
    public $about = [];
    public $contact = [];

    public function mount()
    {
        $defaults = $this->defaultContent();
        $settings = Setting::get('website', []);
        $data = array_replace_recursive($defaults, $settings);

        $this->home = $data['home'];
        $this->about = $data['about'];
        $this->contact = $data['contact'];
    }

    public function save()
    {
        Setting::set('website', [
            'home' => $this->home,
            'about' => $this->about,
            'contact' => $this->contact,
        ], 'website');

        session()->flash('success', 'Website settings updated successfully.');
    }

    public function addAboutStoryParagraph()
    {
        $this->about['story_paragraphs'][] = '';
    }

    public function removeAboutStoryParagraph($index)
    {
        $items = $this->about['story_paragraphs'] ?? [];
        if (!isset($items[$index])) {
            return;
        }
        unset($items[$index]);
        $this->about['story_paragraphs'] = array_values($items);
    }

    public function addAboutBadge()
    {
        $this->about['story_badges'][] = '';
    }

    public function removeAboutBadge($index)
    {
        $items = $this->about['story_badges'] ?? [];
        if (!isset($items[$index])) {
            return;
        }
        unset($items[$index]);
        $this->about['story_badges'] = array_values($items);
    }

    public function addAboutValue()
    {
        $this->about['values'][] = [
            'icon' => 'fas fa-star',
            'title' => 'New Value',
            'description' => '',
            'color' => 'emerald',
        ];
    }

    public function removeAboutValue($index)
    {
        $items = $this->about['values'] ?? [];
        if (!isset($items[$index])) {
            return;
        }
        unset($items[$index]);
        $this->about['values'] = array_values($items);
    }

    public function addAboutMilestone()
    {
        $this->about['milestones'][] = [
            'year' => date('Y'),
            'title' => 'New Milestone',
            'description' => '',
        ];
    }

    public function removeAboutMilestone($index)
    {
        $items = $this->about['milestones'] ?? [];
        if (!isset($items[$index])) {
            return;
        }
        unset($items[$index]);
        $this->about['milestones'] = array_values($items);
    }

    public function addAboutTeamMember()
    {
        $this->about['team'][] = [
            'name' => 'New Member',
            'position' => '',
            'bio' => '',
            'image' => '',
            'social' => [
                'linkedin' => '#',
                'twitter' => '#',
                'email' => '',
            ],
        ];
    }

    public function removeAboutTeamMember($index)
    {
        $items = $this->about['team'] ?? [];
        if (!isset($items[$index])) {
            return;
        }
        unset($items[$index]);
        $this->about['team'] = array_values($items);
    }

    public function addAboutAchievement()
    {
        $this->about['achievements'][] = [
            'year' => date('Y'),
            'award' => '',
            'organization' => '',
            'icon' => 'fas fa-award',
        ];
    }

    public function removeAboutAchievement($index)
    {
        $items = $this->about['achievements'] ?? [];
        if (!isset($items[$index])) {
            return;
        }
        unset($items[$index]);
        $this->about['achievements'] = array_values($items);
    }

    public function addAboutPartner()
    {
        $this->about['partners'][] = [
            'name' => 'New Partner',
            'logo' => '',
        ];
    }

    public function removeAboutPartner($index)
    {
        $items = $this->about['partners'] ?? [];
        if (!isset($items[$index])) {
            return;
        }
        unset($items[$index]);
        $this->about['partners'] = array_values($items);
    }

    public function addAboutStat()
    {
        $this->about['stats'][] = [
            'number' => '',
            'label' => '',
        ];
    }

    public function removeAboutStat($index)
    {
        $items = $this->about['stats'] ?? [];
        if (!isset($items[$index])) {
            return;
        }
        unset($items[$index]);
        $this->about['stats'] = array_values($items);
    }

    public function addContactDepartment()
    {
        $this->contact['departments'][] = [
            'name' => 'New Department',
            'icon' => 'fas fa-info-circle',
            'email' => '',
            'phone' => '',
            'description' => '',
            'color' => 'emerald',
        ];
    }

    public function removeContactDepartment($index)
    {
        $items = $this->contact['departments'] ?? [];
        if (!isset($items[$index])) {
            return;
        }
        unset($items[$index]);
        $this->contact['departments'] = array_values($items);
    }

    public function addContactFaq()
    {
        $this->contact['faqs'][] = [
            'question' => '',
            'answer' => '',
        ];
    }

    public function removeContactFaq($index)
    {
        $items = $this->contact['faqs'] ?? [];
        if (!isset($items[$index])) {
            return;
        }
        unset($items[$index]);
        $this->contact['faqs'] = array_values($items);
    }

    public function addContactSocial()
    {
        $this->contact['socials'][] = [
            'name' => '',
            'icon' => 'fab fa-facebook-f',
            'url' => '',
            'handle' => '',
            'color' => 'blue',
        ];
    }

    public function removeContactSocial($index)
    {
        $items = $this->contact['socials'] ?? [];
        if (!isset($items[$index])) {
            return;
        }
        unset($items[$index]);
        $this->contact['socials'] = array_values($items);
    }

    public function render()
    {
        return view('livewire.admin.settings.website-settings')
            ->layout('layouts.admin', ['header' => 'Website Settings']);
    }

    private function defaultContent(): array
    {
        return [
            'home' => [
                'hero_badge' => 'NOW LIVE ON AIR',
                'hero_title' => 'Your Voice,',
                'hero_highlight' => 'Your Music',
                'hero_subtitle' => 'Broadcasting the heartbeat of the city of Akure, 24/7 on 99.1 FM',
                'primary_cta_text' => 'Listen Live Now',
                'primary_cta_url' => Setting::get('station.stream_url', 'https://stream-176.zeno.fm/mwam2yirv1pvv'),
                'secondary_cta_text' => 'View Schedule',
                'secondary_cta_url' => '/shows',
                'now_playing_label' => 'Currently Playing',
                'now_playing_title' => 'Morning Vibes with MC Olumiko',
                'now_playing_time' => '6:00 AM - 10:00 AM',
            ],
            'about' => [
                'header_title' => 'About Glow FM',
                'header_subtitle' => 'Broadcasting excellence since 2010, bringing you the heartbeat of the city through music, conversation, and community connection.',
                'story_title' => 'Our Story',
                'story_paragraphs' => [
                    'Glow FM 99.1 began in 2010 with a simple yet powerful vision: to create a radio station that truly reflects and celebrates our diverse community. What started as a small local broadcaster has grown into one of the region\'s most beloved and innovative radio stations.',
                    'Over the past 15 years, we\'ve built a reputation for excellence in broadcasting, featuring the best music, the most engaging hosts, and the most compelling content. Our commitment to quality and community has earned us numerous awards and, most importantly, the loyalty of over 1 million monthly listeners.',
                    'Today, Glow FM isn\'t just a radio station—it\'s a cultural institution. We\'re pioneers in digital broadcasting, community engagement, and innovative programming. Every day, we strive to entertain, inform, and inspire our listeners while staying true to our core values.',
                ],
                'story_badges' => [
                    'Award-Winning',
                    'Community-Focused',
                    'Innovation Leaders',
                ],
                'mission_title' => 'Our Mission',
                'mission_body' => 'To deliver exceptional radio broadcasting that entertains, informs, and connects our community. We strive to be the voice of the people, celebrating local culture, music, and stories while maintaining the highest standards of quality and integrity in everything we do.',
                'vision_title' => 'Our Vision',
                'vision_body' => 'To be the leading radio station that shapes cultural conversations, discovers new talent, and pioneers innovative broadcasting technologies. We envision a future where Glow FM continues to be the heartbeat of our community and a model for excellence in radio worldwide.',
                'values_title' => 'Our Core Values',
                'values_subtitle' => 'The principles that guide our decisions and shape our culture',
                'values' => [
                    [
                        'icon' => 'fas fa-heart',
                        'title' => 'Community First',
                        'description' => 'We put our listeners and local community at the heart of everything we do, creating content that resonates and connects.',
                        'color' => 'red',
                    ],
                    [
                        'icon' => 'fas fa-star',
                        'title' => 'Excellence',
                        'description' => 'We strive for excellence in broadcasting, from audio quality to content creation, delivering the best experience possible.',
                        'color' => 'yellow',
                    ],
                    [
                        'icon' => 'fas fa-lightbulb',
                        'title' => 'Innovation',
                        'description' => 'We embrace new technologies and creative approaches to stay ahead and provide cutting-edge entertainment.',
                        'color' => 'emerald',
                    ],
                    [
                        'icon' => 'fas fa-hands-helping',
                        'title' => 'Integrity',
                        'description' => 'We operate with honesty, transparency, and ethical standards in all our interactions and business practices.',
                        'color' => 'blue',
                    ],
                    [
                        'icon' => 'fas fa-users',
                        'title' => 'Diversity',
                        'description' => 'We celebrate diversity in music, voices, and perspectives, creating an inclusive platform for all.',
                        'color' => 'purple',
                    ],
                    [
                        'icon' => 'fas fa-rocket',
                        'title' => 'Passion',
                        'description' => 'Our team is driven by genuine passion for music, broadcasting, and creating memorable experiences for our audience.',
                        'color' => 'orange',
                    ],
                ],
                'milestones_title' => 'Our Journey',
                'milestones_subtitle' => 'Key milestones in our story of growth and innovation',
                'milestones' => [
                    [
                        'year' => '2010',
                        'title' => 'The Beginning',
                        'description' => 'Glow FM 99.1 launched with a vision to revolutionize radio broadcasting and bring fresh, engaging content to the community.',
                    ],
                    [
                        'year' => '2013',
                        'title' => 'Digital Expansion',
                        'description' => 'Launched our online streaming platform, mobile apps, and social media presence, reaching listeners beyond traditional radio.',
                    ],
                    [
                        'year' => '2017',
                        'title' => 'Award Recognition',
                        'description' => 'Won our first National Broadcasting Award for Best Radio Station, recognizing our innovative programming and community engagement.',
                    ],
                    [
                        'year' => '2020',
                        'title' => 'Studio Upgrade',
                        'description' => 'Invested in state-of-the-art broadcasting equipment and renovated our studios to enhance audio quality and production capabilities.',
                    ],
                    [
                        'year' => '2023',
                        'title' => 'Community Impact',
                        'description' => 'Reached 1 million monthly listeners and launched various community programs, charity initiatives, and local talent showcases.',
                    ],
                    [
                        'year' => '2025',
                        'title' => 'Innovation Leader',
                        'description' => 'Pioneered interactive broadcasting technology and became the region\'s most-listened-to radio station with cutting-edge content.',
                    ],
                ],
                'team_title' => 'Meet Our Leadership',
                'team_subtitle' => 'The passionate team behind Glow FM\'s success',
                'team' => [
                    [
                        'name' => 'Michael Rodriguez',
                        'position' => 'Station Manager',
                        'bio' => 'With over 20 years in broadcasting, Michael leads our vision and ensures Glow FM remains at the forefront of radio innovation.',
                        'image' => 'https://ui-avatars.com/api/?name=Michael+Rodriguez&background=10b981&color=fff&size=400',
                        'social' => [
                            'linkedin' => '#',
                            'twitter' => '#',
                            'email' => 'michael@glowfm.com',
                        ],
                    ],
                    [
                        'name' => 'Sarah Johnson',
                        'position' => 'Program Director',
                        'bio' => 'Sarah curates our diverse programming lineup, bringing fresh perspectives and ensuring quality content across all shows.',
                        'image' => 'https://ui-avatars.com/api/?name=Sarah+Johnson&background=f59e0b&color=fff&size=400',
                        'social' => [
                            'linkedin' => '#',
                            'twitter' => '#',
                            'email' => 'sarah@glowfm.com',
                        ],
                    ],
                    [
                        'name' => 'David Chen',
                        'position' => 'Technical Director',
                        'bio' => 'David oversees all technical operations, ensuring seamless broadcasting and maintaining our state-of-the-art equipment.',
                        'image' => 'https://ui-avatars.com/api/?name=David+Chen&background=6366f1&color=fff&size=400',
                        'social' => [
                            'linkedin' => '#',
                            'twitter' => '#',
                            'email' => 'david@glowfm.com',
                        ],
                    ],
                    [
                        'name' => 'Emily Martinez',
                        'position' => 'Marketing Director',
                        'bio' => 'Emily drives our brand strategy and community engagement, connecting Glow FM with audiences across all platforms.',
                        'image' => 'https://ui-avatars.com/api/?name=Emily+Martinez&background=ec4899&color=fff&size=400',
                        'social' => [
                            'linkedin' => '#',
                            'twitter' => '#',
                            'email' => 'emily@glowfm.com',
                        ],
                    ],
                ],
                'achievements_title' => 'Awards & Recognition',
                'achievements_subtitle' => 'Honored for our commitment to excellence in broadcasting',
                'achievements' => [
                    [
                        'year' => '2024',
                        'award' => 'Best Radio Station of the Year',
                        'organization' => 'National Broadcasting Awards',
                        'icon' => 'fas fa-trophy',
                    ],
                    [
                        'year' => '2023',
                        'award' => 'Excellence in Community Engagement',
                        'organization' => 'Media Excellence Awards',
                        'icon' => 'fas fa-award',
                    ],
                    [
                        'year' => '2023',
                        'award' => 'Top Morning Show',
                        'organization' => 'Radio Industry Awards',
                        'icon' => 'fas fa-medal',
                    ],
                    [
                        'year' => '2022',
                        'award' => 'Innovation in Broadcasting',
                        'organization' => 'Tech in Media Awards',
                        'icon' => 'fas fa-lightbulb',
                    ],
                    [
                        'year' => '2021',
                        'award' => 'Most Popular Radio Station',
                        'organization' => 'Listeners\' Choice Awards',
                        'icon' => 'fas fa-heart',
                    ],
                    [
                        'year' => '2020',
                        'award' => 'Outstanding Podcast Series',
                        'organization' => 'Digital Media Awards',
                        'icon' => 'fas fa-podcast',
                    ],
                ],
                'partners_title' => 'Our Partners',
                'partners_subtitle' => 'Proud to work with industry-leading organizations',
                'partners' => [
                    ['name' => 'Music Corp', 'logo' => 'https://via.placeholder.com/200x80/10b981/ffffff?text=Music+Corp'],
                    ['name' => 'Tech Solutions', 'logo' => 'https://via.placeholder.com/200x80/f59e0b/ffffff?text=Tech+Solutions'],
                    ['name' => 'Event Masters', 'logo' => 'https://via.placeholder.com/200x80/6366f1/ffffff?text=Event+Masters'],
                    ['name' => 'Sound Systems', 'logo' => 'https://via.placeholder.com/200x80/ec4899/ffffff?text=Sound+Systems'],
                    ['name' => 'Media Group', 'logo' => 'https://via.placeholder.com/200x80/8b5cf6/ffffff?text=Media+Group'],
                    ['name' => 'Digital Network', 'logo' => 'https://via.placeholder.com/200x80/14b8a6/ffffff?text=Digital+Network'],
                ],
                'stats_title' => 'Glow FM By The Numbers',
                'stats_subtitle' => 'Our impact on the community in numbers',
                'stats' => [
                    ['number' => '1M+', 'label' => 'Monthly Listeners'],
                    ['number' => '50+', 'label' => 'Weekly Shows'],
                    ['number' => '15+', 'label' => 'Years Experience'],
                    ['number' => '25+', 'label' => 'Team Members'],
                ],
                'cta_title' => 'Join Our Community',
                'cta_body' => 'Become part of the Glow FM family. Whether you\'re a listener, advertiser, or potential team member, we\'d love to hear from you!',
                'cta_primary_text' => 'Contact Us',
                'cta_primary_url' => '/contact',
                'cta_secondary_text' => 'Listen Live',
                'cta_secondary_url' => '/',
            ],
            'contact' => [
                'header_title' => 'Get In Touch',
                'header_subtitle' => 'We\'d love to hear from you! Whether you have a question, feedback, or just want to say hello, we\'re here to help.',
                'contact_info' => [
                    'address' => '123 Radio Street, Broadcasting City, BC 12345',
                    'phone' => '+1 (234) 567-890',
                    'email' => 'info@glowfm.com',
                    'hours' => [
                        'weekdays' => '9AM - 6PM',
                        'saturday' => '10AM - 4PM',
                        'sunday' => '10AM - 4PM',
                    ],
                    'map_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.2412648750455!2d-73.98731668459395!3d40.74844097932847!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259a9b3117469%3A0xd134e199a405a163!2sEmpire%20State%20Building!5e0!3m2!1sen!2sus!4v1234567890123!5m2!1sen!2sus',
                ],
                'departments' => [
                    [
                        'name' => 'General Inquiries',
                        'icon' => 'fas fa-info-circle',
                        'email' => 'info@glowfm.com',
                        'phone' => '+1 (234) 567-890',
                        'description' => 'For general questions and information',
                        'color' => 'emerald',
                    ],
                    [
                        'name' => 'Advertising',
                        'icon' => 'fas fa-bullhorn',
                        'email' => 'advertising@glowfm.com',
                        'phone' => '+1 (234) 567-891',
                        'description' => 'Advertising and sponsorship opportunities',
                        'color' => 'blue',
                    ],
                    [
                        'name' => 'Programming',
                        'icon' => 'fas fa-microphone',
                        'email' => 'programming@glowfm.com',
                        'phone' => '+1 (234) 567-892',
                        'description' => 'Show suggestions and program feedback',
                        'color' => 'amber',
                    ],
                    [
                        'name' => 'Technical Support',
                        'icon' => 'fas fa-headset',
                        'email' => 'support@glowfm.com',
                        'phone' => '+1 (234) 567-893',
                        'description' => 'Streaming issues and technical help',
                        'color' => 'purple',
                    ],
                    [
                        'name' => 'Events',
                        'icon' => 'fas fa-calendar-alt',
                        'email' => 'events@glowfm.com',
                        'phone' => '+1 (234) 567-894',
                        'description' => 'Event inquiries and partnerships',
                        'color' => 'pink',
                    ],
                    [
                        'name' => 'Careers',
                        'icon' => 'fas fa-briefcase',
                        'email' => 'careers@glowfm.com',
                        'phone' => '+1 (234) 567-895',
                        'description' => 'Job opportunities and internships',
                        'color' => 'indigo',
                    ],
                ],
                'faqs' => [
                    [
                        'question' => 'How can I listen to Glow FM online?',
                        'answer' => 'You can listen to Glow FM through our website by clicking the "Listen Live" button, downloading our mobile app (available on iOS and Android), or using your favorite radio streaming app by searching for "Glow FM 99.1".',
                    ],
                    [
                        'question' => 'How do I request a song?',
                        'answer' => 'You can request songs through our website contact form, by calling our request line at +1 (234) 567-890, or by sending us a message on our social media channels. Make sure to include the song title and artist name!',
                    ],
                    [
                        'question' => 'Can I visit the studio?',
                        'answer' => 'Yes! We offer studio tours by appointment. Please contact us at least one week in advance to schedule your visit. Group tours for schools and organizations are also available.',
                    ],
                    [
                        'question' => 'How do I advertise on Glow FM?',
                        'answer' => 'For advertising opportunities, please contact our advertising department at advertising@glowfm.com or call +1 (234) 567-891. Our team will help you create a custom advertising package that fits your needs and budget.',
                    ],
                    [
                        'question' => 'Are you hiring?',
                        'answer' => 'We\'re always looking for talented individuals! Check our careers page or send your resume and cover letter to careers@glowfm.com. We offer opportunities for DJs, producers, marketing professionals, and more.',
                    ],
                    [
                        'question' => 'How can I sponsor an event?',
                        'answer' => 'We love partnering with local businesses for events! Contact our events team at events@glowfm.com to discuss sponsorship opportunities and how we can work together to create memorable experiences.',
                    ],
                ],
                'socials' => [
                    ['name' => 'Facebook', 'icon' => 'fab fa-facebook-f', 'url' => '#', 'handle' => '@glowfm991', 'color' => 'blue'],
                    ['name' => 'Twitter', 'icon' => 'fab fa-twitter', 'url' => '#', 'handle' => '@glowfm', 'color' => 'sky'],
                    ['name' => 'Instagram', 'icon' => 'fab fa-instagram', 'url' => '#', 'handle' => '@glowfm991', 'color' => 'pink'],
                    ['name' => 'YouTube', 'icon' => 'fab fa-youtube', 'url' => '#', 'handle' => 'Glow FM 99.1', 'color' => 'red'],
                    ['name' => 'TikTok', 'icon' => 'fab fa-tiktok', 'url' => '#', 'handle' => '@glowfm', 'color' => 'slate'],
                    ['name' => 'LinkedIn', 'icon' => 'fab fa-linkedin-in', 'url' => '#', 'handle' => 'Glow FM', 'color' => 'indigo'],
                ],
            ],
        ];
    }
}
