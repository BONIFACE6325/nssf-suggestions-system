<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utafiti wa Kuridhika kwa Wateja - NSSF Tanzania</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom Tailwind colors for NSSF branding */
        :root {
            --nssf-yellow: #FFD100;
            --nssf-maroon: #862633;
            --nssf-dark: #333333;
            --nssf-light: #f8f9fa;
            --nssf-light-yellow: #FFF9E6;
        }
    </style>
</head>
<body class="bg-gray-100 bg-[url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQP8MnOJod7sKHG03dJkiuYz1IyfjwDLPKrsw&s')] bg-cover bg-center bg-fixed relative">
    <!-- Overlay for background image -->
    <div class="absolute inset-0 bg-white bg-opacity-90 z-[-1]"></div>

        <div class="container mx-auto px-4 py-6 max-w-7xl flex flex-col lg:flex-row gap-6">
            <!-- Main Content -->
    <div class="flex-1">
        <header class="bg-gradient-to-r from-[var(--nssf-maroon)] to-[var(--nssf-yellow)] text-white p-6 rounded-t-lg shadow-lg text-center">
          <div class="flex justify-center items-center mb-4">
            <img src="{{ asset('images/logo.png') }}" alt="Site Logo" class="w-30 h-20 object-contain mr-4">
            <div class="text-left">
                <h1 class="text-2xl font-bold">Mfuko wa Taifa wa Hifadhi ya Jamii</h1>
                <p class="text-lg">Utafiti wa Kuridhika kwa Wateja</p>
            </div>
        </div>
        </header>


            <div class="bg-white p-6 rounded-b-lg shadow-md border-l-4 border-[var(--nssf-yellow)] mb-6">
                <p class="mb-4"><strong>Ndugu Mteja/Mwanachama wa NSSF,</strong></p>
                <p>Mfuko ungependa kupata mrejesho wa huduma unazopokea kupitia ofisi zetu ili kukidhi matarajio yako. Kupitia fomu hii, weka alama ya (✓) katika kisanduku cha chaguo lako ili kutusaidia Mfuko kutathmini ubora wa huduma zake.</p>
            </div>

            <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                <div class="bg-gradient-to-r from-[var(--nssf-maroon)] to-[var(--nssf-yellow)] h-2 rounded-full w-1/5"></div>
            </div>
            <!-- <p class="text-right text-[var(--nssf-maroon)] font-bold mb-4">20% imekamilika</p> -->

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <form class="survey-form bg-white p-8 rounded-lg shadow-md mb-6" id="satisfactionSurvey" method="POST" action="{{ route('feedback.store') }}">
                @csrf
                <!-- Taarifa za Msaili -->
                <div class="mb-8 border-b-2 border-dashed border-gray-200 pb-6">
                    <h2 class="text-xl font-semibold text-[var(--nssf-maroon)] mb-4 flex items-center">
                        <i class="fas fa-user-circle mr-2 bg-[var(--nssf-maroon)] text-[var(--nssf-yellow)] p-2 rounded-full"></i>
                        Taarifa za Msaili
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="region" class="block text-[var(--nssf-maroon)] font-bold mb-2">Mkoa <span class="text-red-500">*</span></label>
                            <select id="region" name="region_id" class="w-full p-3 border-2 border-gray-300 rounded-lg focus:border-[var(--nssf-yellow)] focus:ring focus:ring-[var(--nssf-yellow)] focus:ring-opacity-50" required>
                                <option value="">--Chagua Mkoa--</option>
                                @foreach($regions as $region)
                                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                                @endforeach
                            </select>
                            @error('region_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-[var(--nssf-maroon)] font-bold mb-2">Jinsia <span class="text-red-500">*</span></label>
                            <div class="space-y-2">
                                <div class="flex items-center hover:pl-2 transition-transform">
                                    <input type="radio" id="male" name="gender" value="ME" class="mr-2 accent-[var(--nssf-maroon)]" required>
                                    <label for="male" class="cursor-pointer">Me</label>
                                </div>
                                <div class="flex items-center hover:pl-2 transition-transform">
                                    <input type="radio" id="female" name="gender" value="MKE" class="mr-2 accent-[var(--nssf-maroon)]">
                                    <label for="female" class="cursor-pointer">Ke</label>
                                </div>
                            </div>
                            @error('gender')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-[var(--nssf-maroon)] font-bold mb-2">Utambulisho wako <span class="text-red-500">*</span></label>
                        <div class="space-y-2">
                            @foreach(['Mwajiriwa', 'Hiari', 'Mstaafu', 'Mtegemezi', 'Sio Mwanachama'] as $index => $membership)
                                <div class="flex items-center hover:pl-2 transition-transform">
                                    <input type="radio" id="member{{ $index + 1 }}" name="membership" value="{{ $membership }}" class="mr-2 accent-[var(--nssf-maroon)]" required>
                                    <label for="member{{ $index + 1 }}" class="cursor-pointer">{{ $membership }}</label>
                                </div>
                            @endforeach
                        </div>
                        @error('membership')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Taarifa za Ujio Wako -->
                <div class="mb-8 border-b-2 border-dashed border-gray-200 pb-6">
                    <h2 class="text-xl font-semibold text-[var(--nssf-maroon)] mb-4 flex items-center">
                        <i class="fas fa-info-circle mr-2 bg-[var(--nssf-maroon)] text-[var(--nssf-yellow)] p-2 rounded-full"></i>
                        Taarifa za Ujio Wako
                    </h2>

                    <div class="mb-6">
                        <label class="block text-[var(--nssf-maroon)] font-bold mb-2">Sababu ya ujio wako <span class="text-red-500">*</span></label>
                        <div class="space-y-2">
                            @foreach(['Mafao', 'Usajili', 'Michango', 'Nyaraka'] as $index => $reason)
                                <div class="flex items-center hover:pl-2 transition-transform">
                                    <input type="radio" id="reason{{ $index + 1 }}" name="visit_reason" value="{{ $reason }}" class="mr-2 accent-[var(--nssf-maroon)]" required>
                                    <label for="reason{{ $index + 1 }}" class="cursor-pointer">{{ $reason }}</label>
                                </div>
                            @endforeach
                        </div>
                        @error('visit_reason')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-[var(--nssf-maroon)] font-bold mb-2">Muda wa kusubiri <span class="text-red-500">*</span></label>
                        <div class="space-y-2">
                            @foreach(['0-10', '10-20', '20-30', '30-60'] as $index => $time)
                                <div class="flex items-center hover:pl-2 transition-transform">
                                    <input type="radio" id="wait{{ $index + 1 }}" name="waiting_time" value="{{ $time }}" class="mr-2 accent-[var(--nssf-maroon)]" required>
                                    <label for="wait{{ $index + 1 }}" class="cursor-pointer">{{ $time }} Dakika</label>
                                </div>
                            @endforeach
                        </div>
                        @error('waiting_time')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Tathmini ya Huduma -->
                <div class="mb-8 border-b-2 border-dashed border-gray-200 pb-6">
                    <h2 class="text-xl font-semibold text-[var(--nssf-maroon)] mb-4 flex items-center">
                        <i class="fas fa-star mr-2 bg-[var(--nssf-maroon)] text-[var(--nssf-yellow)] p-2 rounded-full"></i>
                        Tathmini ya Huduma
                    </h2>

                    @foreach([
                        ['name' => 'satisfaction_time', 'label' => 'Umeridhika na muda?', 'options' => ['Nimeridhika sana', 'Nimeridhika', 'Sina uhakika', 'Sijaridhika', 'Sijaridhika kabisa']],
                        ['name' => 'needs_met', 'label' => 'Kukidhi mahitaji', 'options' => ['Zinakidhi sana', 'Zinakidhi', 'Sina hakika', 'Hazikidhi', 'Hazikidhi kabisa']],
                        ['name' => 'service_quality', 'label' => 'Ubora wa huduma', 'options' => ['Zimeboreshwa sana', 'Zimeboreshwa', 'Za wastani', 'Zimedoro']],
                        ['name' => 'problem_handling', 'label' => 'Kushughulikia matatizo', 'options' => ['Kwa haraka sana', 'Kwa haraka', 'Sina hakika', 'Taratibu', 'Taratibu sana']],
                        ['name' => 'staff_responsiveness', 'label' => 'Uwajibikaji wa wafanyakazi', 'options' => ['Wanawajibika sana', 'Wanawajibika', 'Kwa wastani', 'Hawawajibiki', 'Hawawajibiki kabisa']],
                        ['name' => 'overall_satisfaction', 'label' => 'Kwa ujumla umeridhika?', 'options' => ['Ninaridhika sana', 'Ninaridhika', 'Sina uhakika', 'Siridhiki']],
                    ] as $index => $section)
                        <div class="mb-6">
                            <label class="block text-[var(--nssf-maroon)] font-bold mb-2">{{ $section['label'] }} <span class="text-red-500">*</span></label>
                            <div class="space-y-2">
                                @foreach($section['options'] as $option)
                                    <div class="flex items-center hover:pl-2 transition-transform">
                                        <input type="radio" name="{{ $section['name'] }}" value="{{ $option }}" class="mr-2 accent-[var(--nssf-maroon)]" required>
                                        <label class="cursor-pointer">{{ $option }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error($section['name'])
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    @endforeach
                </div>

                <!-- Maoni ya Ziada -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-[var(--nssf-maroon)] mb-4 flex items-center">
                        <i class="fas fa-comments mr-2 bg-[var(--nssf-maroon)] text-[var(--nssf-yellow)] p-2 rounded-full"></i>
                        Maoni ya Ziada
                    </h2>
                    <div>
                        <textarea id="suggestions" name="suggestions" placeholder="Andika maoni yako hapa..." class="w-full p-3 border-2 border-gray-300 rounded-lg focus:border-[var(--nssf-yellow)] focus:ring focus:ring-[var(--nssf-yellow)] focus:ring-opacity-50 min-h-[120px]"></textarea>
                        @error('suggestions')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="bg-gradient-to-r from-[var(--nssf-maroon)] to-[#9c3a4a] text-white px-8 py-4 rounded-lg shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 block mx-auto text-lg font-bold">
                    <i class="fas fa-paper-plane mr-2"></i> Wasilisha Uchambuzi Wako
                </button>
            </form>

            <footer class="text-center bg-white bg-opacity-80 p-6 rounded-lg shadow-md">
                <p class="mb-4">Asante kwa kuchukua muda wako kujaza fomu hii. Maoni yako yanatusaidia kuboresha huduma zetu.</p>
                <div class="flex justify-center gap-6 mb-4">
                    <a href="#" class="text-[var(--nssf-maroon)] hover:text-[var(--nssf-yellow)] hover:underline"><i class="fas fa-lock mr-1"></i> Sera ya Faragha</a>
                    <a href="#" class="text-[var(--nssf-maroon)] hover:text-[var(--nssf-yellow)] hover:underline"><i class="fas fa-file-alt mr-1"></i> Sheria na Vifungu</a>
                    <a href="#" class="text-[var(--nssf-maroon)] hover:text-[var(--nssf-yellow)] hover:underline"><i class="fas fa-phone mr-1"></i> Mawasiliano</a>
                </div>
                <p>© 2023 Mfuko wa Taifa wa Hifadhi ya Jamii (NSSF). Haki zote zimehifadhiwa.</p>
            </footer>
        </div>

        <!-- Side Content -->
        <div class="w-full lg:w-80 space-y-6">
            <!-- Huduma Za NSSF -->
            <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-[var(--nssf-maroon)]">
                <h3 class="text-lg font-semibold text-[var(--nssf-maroon)] mb-4 flex items-center">
                    <i class="fas fa-concierge-bell mr-2 bg-[var(--nssf-maroon)] text-[var(--nssf-yellow)] p-2 rounded-full"></i>
                    Huduma Za NSSF
                </h3>
                <ul class="space-y-3">
                    @foreach([
                        ['icon' => 'fa-building', 'text' => 'Huduma kwa Waajiri'],
                        ['icon' => 'fa-user-md', 'text' => 'Huduma kwa Watoa Huduma za Afya'],
                        ['icon' => 'fa-truck-loading', 'text' => 'Huduma kwa Wasambazaji'],
                        ['icon' => 'fa-users', 'text' => 'Huduma kwa Wanachama'],
                        ['icon' => 'fa-bridge', 'text' => 'Huduma ya Mabaraza'],
                        ['icon' => 'fa-user-tie', 'text' => 'Huduma kwa Wakuu'],
                    ] as $service)
                        <li class="flex items-center border-b border-dashed border-gray-200 pb-3 last:border-b-0">
                            <i class="fas {{ $service['icon'] }} mr-2 bg-[var(--nssf-light-yellow)] text-[var(--nssf-maroon)] p-2 rounded-full"></i>
                            {{ $service['text'] }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Takwimu Za NSSF -->
            <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-[var(--nssf-maroon)]">
                <h3 class="text-lg font-semibold text-[var(--nssf-maroon)] mb-4 flex items-center">
                    <i class="fas fa-chart-line mr-2 bg-[var(--nssf-maroon)] text-[var(--nssf-yellow)] p-2 rounded-full"></i>
                    Takwimu Za NSSF
                </h3>
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div class="p-4 bg-[var(--nssf-light-yellow)] rounded-lg">
                        <div class="text-2xl font-bold text-[var(--nssf-maroon)]">2.5M+</div>
                        <div class="text-sm text-[var(--nssf-dark)]">Wanachama</div>
                    </div>
                    <div class="p-4 bg-[var(--nssf-light-yellow)] rounded-lg">
                        <div class="text-2xl font-bold text-[var(--nssf-maroon)]">50K+</div>
                        <div class="text-sm text-[var(--nssf-dark)]">Waajiri</div>
                    </div>
                    <div class="p-4 bg-[var(--nssf-light-yellow)] rounded-lg">
                        <div class="text-2xl font-bold text-[var(--nssf-maroon)]">25</div>
                        <div class="text-sm text-[var(--nssf-dark)]">Mikoa</div>
                    </div>
                    <div class="p-4 bg-[var(--nssf-light-yellow)] rounded-lg">
                        <div class="text-2xl font-bold text-[var(--nssf-maroon)]">45+</div>
                        <div class="text-sm text-[var(--nssf-dark)]">Miaka ya Huduma</div>
                    </div>
                </div>
            </div>

            <!-- Habari na Matukio -->
            <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-[var(--nssf-maroon)]">
                <h3 class="text-lg font-semibold text-[var(--nssf-maroon)] mb-4 flex items-center">
                    <i class="fas fa-newspaper mr-2 bg-[var(--nssf-maroon)] text-[var(--nssf-yellow)] p-2 rounded-full"></i>
                    Habari na Matukio
                </h3>
                @foreach([
                    ['date' => '12 Oktoba, 2023', 'title' => 'Mabadiliko ya Kiwango cha Michango', 'text' => 'NSSF imepitisha mabadiliko mapya ya kiwango cha michango kuanzia mwezi Januari...'],
                    ['date' => '28 Septemba, 2023', 'title' => 'Ofisi Mpya Mkoani Dodoma', 'text' => 'Ofisi mpya ya NSSF imefunguliwa mkoani Dodoma kwa lengo la kuwahudumia wanachama vyema...'],
                ] as $news)
                    <div class="mb-4 last:mb-0 last:border-b-0 border-b border-gray-200 pb-4">
                        <span class="text-sm text-gray-500 block mb-2"><i class="fas fa-calendar-alt mr-1"></i> {{ $news['date'] }}</span>
                        <h4 class="text-[var(--nssf-maroon)] font-semibold">{{ $news['title'] }}</h4>
                        <p>{{ $news['text'] }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Viungo Muhimu -->
            <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-[var(--nssf-maroon)]">
                <h3 class="text-lg font-semibold text-[var(--nssf-maroon)] mb-4 flex items-center">
                    <i class="fas fa-link mr-2 bg-[var(--nssf-maroon)] text-[var(--nssf-yellow)] p-2 rounded-full"></i>
                    Viungo Muhimu
                </h3>
                <div class="space-y-3">
                    @foreach([
                        ['icon' => 'fa-user-plus', 'text' => 'Jiunge na NSSF'],
                        ['icon' => 'fa-calculator', 'text' => 'Kikokotoo cha Pensheni'],
                        ['icon' => 'fa-download', 'text' => 'Pakua Fomu Mbalimbali'],
                        ['icon' => 'fa-question-circle', 'text' => 'Maswali Yanayoulizwa Mara Kwa Mara'],
                        ['icon' => 'fa-book', 'text' => 'Mwongozo wa Mwanachama'],
                    ] as $link)
                        <a href="#" class="flex items-center p-3 bg-[var(--nssf-light)] rounded-lg hover:bg-[var(--nssf-light-yellow)] hover:translate-x-1 transition-all">
                            <i class="fas {{ $link['icon'] }} mr-2 text-[var(--nssf-maroon)]"></i>
                            {{ $link['text'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Wasiliana Nasi -->
            <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-[var(--nssf-maroon)]">
                <h3 class="text-lg font-semibold text-[var(--nssf-maroon)] mb-4 flex items-center">
                    <i class="fas fa-phone-alt mr-2 bg-[var(--nssf-maroon)] text-[var(--nssf-yellow)] p-2 rounded-full"></i>
                    Wasiliana Nasi
                </h3>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <i class="fas fa-phone mr-3 bg-[var(--nssf-light-yellow)] text-[var(--nssf-maroon)] p-3 rounded-full"></i>
                        <div>
                            <div>Namba ya Simu: 0800110011</div>
                            <small class="text-gray-500">Zipo huru kwa kuitwa</small>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-envelope mr-3 bg-[var(--nssf-light-yellow)] text-[var(--nssf-maroon)] p-3 rounded-full"></i>
                        <div>info@nssf.co.tz</div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-globe mr-3 bg-[var(--nssf-light-yellow)] text-[var(--nssf-maroon)] p-3 rounded-full"></i>
                        <div>www.nssf.co.tz</div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt mr-3 bg-[var(--nssf-light-yellow)] text-[var(--nssf-maroon)] p-3 rounded-full"></i>
                        <div>Makao Makuu: Dar es Salaam, Tanzania</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>