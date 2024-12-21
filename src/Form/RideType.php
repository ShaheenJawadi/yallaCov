<?php
namespace App\Form;

use App\Entity\Ride;
use App\Enum\RideStatus;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('departureCity', TextType::class, [
                'label' => 'Ville de départ',
            ])
            ->add('arrivalCity', TextType::class, [
                'label' => 'Ville d\'arrivée',
            ])
            ->add('departureDate', DateType::class, [
                'label' => 'Date de départ',
                'widget' => 'single_text',
            ])
            ->add('departureTime', TimeType::class, [
                'label' => 'Heure de départ',
            ])
            ->add('availableSeats', IntegerType::class, [
                'label' => 'Places disponibles',
            ])
            ->add('pricePerSeat', NumberType::class, [
                'label' => 'Prix par place',
                'scale' => 2,
            ])
            ->add('vehicleDescription', TextareaType::class, [
                'label' => 'Description du véhicule',
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'En attente' => RideStatus::PENDING,
                    'Confirmé' => RideStatus::COMPLETED,
                    'Annulé' => RideStatus::CANCELLED,
                ],
            ])
            ->add('isActive', ChoiceType::class, [
                'label' => 'Actif',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'expanded' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ride::class,
        ]);
    }
}
