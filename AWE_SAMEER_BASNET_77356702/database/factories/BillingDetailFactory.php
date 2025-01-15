<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BillingDetail>
 */
class BillingDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $provincesWithDistricts = [
            'Province No. 1' => [
                'Bhojpur' => ['Bhojpur Municipality', 'Shadananda Municipality', 'Arun Rural Municipality'],
                'Dhankuta' => ['Dhankuta Municipality', 'Pakhribas Municipality', 'Chaubise Rural Municipality'],
                'Ilam' => ['Ilam Municipality', 'Deumai Municipality', 'Mai Municipality'],
                'Jhapa' => ['Birtamod', 'Damak', 'Mechinagar'],
                'Khotang' => ['Diktel Rupakot Majhuwagadi', 'Halesi Tuwachung', 'Khotehang'],
                'Morang' => ['Biratnagar', 'Belbari', 'Sundar Haraicha'],
                'Okhaldhunga' => ['Okhaldhunga', 'Manebhanjyang', 'Chisankhugadhi'],
                'Panchthar' => ['Phidim', 'Yangwarak', 'Kummayak'],
                'Sankhuwasabha' => ['Khandbari', 'Chainpur', 'Makalu'],
                'Solukhumbu' => ['Salleri', 'Namche Bazaar', 'Lukla'],
                'Sunsari' => ['Itahari', 'Dharan', 'Inaruwa'],
                'Taplejung' => ['Taplejung', 'Phungling', 'Mikkwakhola'],
                'Terhathum' => ['Myanglung', 'Laligurans Municipality', 'Aathrai'],
                'Udayapur' => ['Triyuga', 'Katari', 'Belaka']
            ],
            'Madhesh Province' => [
                'Bara' => ['Kalaiya', 'Jeetpur Simara', 'Kolhabi'],
                'Dhanusha' => ['Janakpur', 'Sabaila', 'Mithila'],
                'Mahottari' => ['Jaleshwar', 'Bardibas', 'Matihani'],
                'Parsa' => ['Birgunj', 'Pokhariya', 'Parsagadhi'],
                'Rautahat' => ['Gaur', 'Garuda', 'Chandrapur'],
                'Saptari' => ['Rajbiraj', 'Kanchanrup', 'Hanumannagar'],
                'Sarlahi' => ['Malangwa', 'Ishwarpur', 'Haripur'],
                'Siraha' => ['Siraha', 'Lahan', 'Mirchaiya']
            ],
            'Bagmati Province' => [
                'Bhaktapur' => ['Bhaktapur', 'Madhyapur Thimi', 'Suryabinayak'],
                'Chitwan' => ['Bharatpur', 'Ratnanagar', 'Kalika'],
                'Dhading' => ['Nilkantha', 'Dhunibeshi', 'Galchhi'],
                'Dolakha' => ['Charikot', 'Bhimeshwor', 'Jiri'],
                'Kathmandu' => ['Kathmandu', 'Kirtipur', 'Gokarneshwor'],
                'Kavrepalanchok' => ['Dhulikhel', 'Banepa', 'Panauti'],
                'Lalitpur' => ['Lalitpur', 'Godawari', 'Mahalaxmi'],
                'Makwanpur' => ['Hetauda', 'Thaha Municipality', 'Manahari'],
                'Nuwakot' => ['Bidur', 'Tadi', 'Belkotgadhi'],
                'Ramechhap' => ['Manthali', 'Ramechhap', 'Khadadevi'],
                'Rasuwa' => ['Dhunche', 'Kalika', 'Uttargaya'],
                'Sindhuli' => ['Kamalamai', 'Dudhauli', 'Sunkoshi'],
                'Sindhupalchok' => ['Chautara', 'Melamchi', 'Barhabise']
            ],
            'Gandaki Province' => [
                'Baglung' => ['Baglung', 'Galkot', 'Jaimini'],
                'Gorkha' => ['Gorkha', 'Palungtar', 'Aarughat'],
                'Kaski' => ['Pokhara', 'Lekhnath', 'Machhapuchhre'],
                'Lamjung' => ['Besisahar', 'Rainas', 'Sundarbazar'],
                'Manang' => ['Chame', 'Nyeshang', 'Nar'],
                'Mustang' => ['Jomsom', 'Kagbeni', 'Marpha'],
                'Myagdi' => ['Beni', 'Annapurna', 'Raghuganga'],
                'Nawalpur' => ['Kawasoti', 'Gaindakot', 'Devchuli'],
                'Parbat' => ['Kushma', 'Phalebas', 'Jaljala'],
                'Syangja' => ['Putalibazar', 'Waling', 'Bhirkot'],
                'Tanahun' => ['Damauli', 'Bhanu', 'Bandipur']
            ],
            'Lumbini Province' => [
                'Arghakhanchi' => ['Sandhikharka', 'Shitganga', 'Bhumikasthan'],
                'Banke' => ['Nepalgunj', 'Kohalpur', 'Raptisonari'],
                'Bardiya' => ['Gulariya', 'Rajapur', 'Madhuwan'],
                'Dang' => ['Ghorahi', 'Tulsipur', 'Lamahi'],
                'Gulmi' => ['Tamghas', 'Resunga', 'Madane'],
                'Kapilvastu' => ['Kapilvastu', 'Shivaraj', 'Buddhabhumi'],
                'Parasi' => ['Ramgram', 'Sunawal', 'Bardaghat'],
                'Palpa' => ['Tansen', 'Rampur', 'Bagnaskali'],
                'Pyuthan' => ['Pyuthan', 'Swargadwari', 'Gaumukhi'],
                'Rolpa' => ['Liwang', 'Thawang', 'Runtigadhi'],
                'Rukum (East)' => ['Rukumkot', 'Bhume', 'Putha Uttarganga'],
                'Rupandehi' => ['Butwal', 'Siddharthanagar', 'Devdaha']
            ],
            'Karnali Province' => [
                'Dailekh' => ['Narayan', 'Dullu', 'Chamunda Bindrasaini'],
                'Dolpa' => ['Dunai', 'Tripurasundari', 'Chharka Tangsong'],
                'Humla' => ['Simikot', 'Namkha', 'Kharpunath'],
                'Jajarkot' => ['Jajarkot', 'Barekot', 'Chhedagad'],
                'Jumla' => ['Khalanga', 'Hima', 'Tatopani'],
                'Kalikot' => ['Manma', 'Pachaljharna', 'Palata'],
                'Mugu' => ['Gamgadhi', 'Khatyad', 'Soru'],
                'Rukum (West)' => ['Musikot', 'Chaurjahari', 'Sanibheri'],
                'Salyan' => ['Salyan', 'Sharada', 'Bangad Kupinde'],
                'Surkhet' => ['Birendranagar', 'Bheriganga', 'Lekbeshi']
            ],
            'Sudurpashchim Province' => [
                'Achham' => ['Mangalsen', 'Kamalbazar', 'Sanphebagar'],
                'Baitadi' => ['Dasharathchand', 'Patan', 'Purchaudi'],
                'Bajhang' => ['Chainpur', 'Talkot', 'Jayaprithvi'],
                'Bajura' => ['Martadi', 'Badimalika', 'Budhiganga'],
                'Dadeldhura' => ['Amargadhi', 'Parshuram', 'Aalital'],
                'Darchula' => ['Darchula', 'Marma', 'Byas'],
                'Doti' => ['Silgadhi', 'Dipayal', 'Bogatan'],
                'Kailali' => ['Dhangadhi', 'Tikapur', 'Lamki Chuha'],
                'Kanchanpur' => ['Mahendranagar', 'Belauri', 'Punarbas']
            ]
        ];
        

        // Randomly select a province
        $province = array_rand($provincesWithDistricts);

        // Randomly select a district from the selected province
        $district = array_rand($provincesWithDistricts[$province]);

        // Randomly select a city from the selected district
        $city = $this->faker->randomElement($provincesWithDistricts[$province][$district]);

        // Generate a phone number in +977 format
        $phone = '+977-' . $this->faker->numberBetween(9800000000, 9899999999);

        return [
            'user_id' => User::factory(), // Assumes a User factory exists
            'country' => $province, // Set the province as the 'country' field
            'state' => $district, // Set the district as the 'state' field
            'city' => $city, // Use a city name related to the district
            'billing_address' => $this->faker->streetAddress(),
            'zipcode' => $this->faker->postcode(),
            'phone' => $phone,
            'order_notes' => $this->faker->optional()->sentence(),
        ];
    }
}
