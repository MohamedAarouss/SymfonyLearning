<?php

namespace App\DataFixtures;

use App\Entity\Disease;
use App\Entity\Hospital;
use App\Entity\StatusDisease;
use App\Entity\TakeTreatment;
use App\Entity\Treatment;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DataFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {



        /*------- hospital -------*/

        $lille = new Hospital();
        $lille->setName('CHRU Lille');
        $manager->persist($lille);

        $arras = new Hospital();
        $arras->setName('CH Arras');
        $manager->persist($arras);

        $lens = new Hospital();
        $lens->setName('CH Lens');
        $manager->persist($lens);

        /*------- user -------*/

        $zimzim = new User();
        $zimzim->setUsername('zimzim');
        $plainPassword = $zimzim->getUsername();
        $encoded = $this->encoder->encodePassword($zimzim, $plainPassword);
        $zimzim->setPassword($encoded);
        $zimzim->setCreatedAt(new \DateTime('now'));
        $zimzim->setHospital($arras);
        $zimzim->addRole('ROLE_MEDECIN');
        $manager->persist($zimzim);

        $pauline = new User();
        $pauline->setUsername('pauline');
        $plainPassword = $pauline->getUsername();
        $encoded = $this->encoder->encodePassword($pauline, $plainPassword);
        $pauline->setPassword($encoded);
        $pauline->setCreatedAt(new \DateTime('now'));
        $pauline->setHospital($lille);
        $manager->persist($pauline);

        $jp = new User();
        $jp->setUsername('jean paul');
        $plainPassword = $jp->getUsername();
        $encoded = $this->encoder->encodePassword($jp, $plainPassword);
        $jp->setPassword($encoded);
        $jp->setCreatedAt(new \DateTime('now'));
        $jp->setHospital($lille);
        $manager->persist($jp);

        $roger = new User();
        $roger->setUsername('roger');
        $plainPassword = $roger->getUsername();
        $encoded = $this->encoder->encodePassword($roger, $plainPassword);
        $roger->setPassword($encoded);
        $roger->setCreatedAt(new \DateTime('now'));
        $roger->setHospital($lens);
        $manager->persist($roger);

        $tiffany = new User();
        $tiffany->setUsername('tiffany');
        $plainPassword = $tiffany->getUsername();
        $encoded = $this->encoder->encodePassword($tiffany, $plainPassword);
        $tiffany->setPassword($encoded);
        $tiffany->setCreatedAt(new \DateTime('now'));
        $tiffany->setHospital($lens);
        $manager->persist($tiffany);

        $hugette = new User();
        $hugette->setUsername('hugette');
        $plainPassword = $hugette->getUsername();
        $encoded = $this->encoder->encodePassword($hugette, $plainPassword);
        $hugette->setPassword($encoded);
        $hugette->setCreatedAt(new \DateTime('now'));
        $hugette->setHospital($arras);
        $manager->persist($hugette);

        /*------- Disease -------*/
        $cancer = new Disease();
        $cancer->setName("cancer du colon");
        $cancer->setRisk(1000);
        $manager->persist($cancer);

        $covid = new Disease();
        $covid->setName("covid19");
        $covid->setRisk(50);
        $manager->persist($covid);

        $meningite = new Disease();
        $meningite->setName("meningite");
        $meningite->setRisk(20);
        $manager->persist($meningite);


        /*------- treat -------*/
        $treat1 = new Treatment();
        $treat1->setName("Chimiothérapie");
        $treat1->setDosage(5);
        $treat1->setDisease($cancer);
        $treat1->addHospital($arras);
        $treat1->addHospital($lens);
        $manager->persist($treat1);

        $treat2 = new Treatment();
        $treat2->setName("Chimiothérapie alternative");
        $treat2->setDosage(2);
        $treat2->setDisease($cancer);
        $treat2->addHospital($lille);
        $manager->persist($treat2);

        $treat3 = new Treatment();
        $treat3->setName("Respitateur");
        $treat3->setDosage(10);
        $treat3->setDisease($covid);
        $treat3->addHospital($arras);
        $treat3->addHospital($lens);
        $treat3->addHospital($lille);
        $manager->persist($treat3);

        $treat4 = new Treatment();
        $treat4->setName("hydroxy-chloroquine");
        $treat4->setDosage(5);
        $treat4->setDisease($covid);
        $treat4->addHospital($arras);
        $treat4->addHospital($lille);
        $manager->persist($treat4);

        $treat5 = new Treatment();
        $treat5->setName("Cachet de la mort qui tue");
        $treat5->setDosage(1);
        $treat5->addHospital($arras);
        $treat5->addHospital($lille);
        $treat5->setDisease($meningite);
        $manager->persist($treat5);

        /*** status **/
        $status = new StatusDisease();
        $status->setCreatedAt(new \DateTime('now'));
        $status->setBeaten(false);
        $status->setDisease($cancer);
        $status->setUser($jp);
        $manager->persist($status);

        $status = new StatusDisease();
        $status->setCreatedAt(new \DateTime('now'));
        $status->setBeaten(false);
        $status->setDisease($covid);
        $status->setUser($jp);
        $manager->persist($status);

        $status = new StatusDisease();
        $status->setCreatedAt(new \DateTime('now'));
        $status->setBeaten(false);
        $status->setDisease($meningite);
        $status->setUser($jp);
        $manager->persist($status);

        $status = new StatusDisease();
        $status->setCreatedAt(new \DateTime('now'));
        $status->setBeaten(false);
        $status->setDisease($cancer);
        $status->setUser($roger);
        $manager->persist($status);


        $status1 = new StatusDisease();
        $status1->setCreatedAt(new \DateTime('now'));
        $status1->setBeaten(false);
        $status1->setDisease($covid);
        $status1->setUser($pauline);
        $manager->persist($status1);

        $status = new StatusDisease();
        $status->setCreatedAt(new \DateTime('now'));
        $status->setBeaten(false);
        $status->setDisease($meningite);
        $status->setUser($pauline);
        $manager->persist($status);

        $status = new StatusDisease();
        $status->setCreatedAt(new \DateTime('now'));
        $status->setBeaten(false);
        $status->setDisease($covid);
        $status->setUser($tiffany);
        $manager->persist($status);

        $status = new StatusDisease();
        $status->setCreatedAt(new \DateTime('now'));
        $status->setBeaten(false);
        $status->setDisease($covid);
        $status->setUser($hugette);
        $manager->persist($status);

        $takeTreatments = new TakeTreatment();
        $takeTreatments->setCreatedAt(new \DateTime('now'));
        $takeTreatments->setFail(false);
        $takeTreatments->setStatusDisease($status1);
        $takeTreatments->setTraitment($treat3);
        $manager->persist($takeTreatments);

        $takeTreatments = new TakeTreatment();
        $takeTreatments->setCreatedAt(new \DateTime('now'));
        $takeTreatments->setFail(true);
        $takeTreatments->setStatusDisease($status1);
        $takeTreatments->setTraitment($treat3);
        $manager->persist($takeTreatments);

        $manager->flush();
    }
}
