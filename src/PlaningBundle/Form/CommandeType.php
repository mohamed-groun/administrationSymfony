<?php

namespace PlaningBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('commentaire',TextareaType::class ,[
        'label' => 'Ajouter des notes',
            ])->add('retour',HiddenType::class,[
                'data'=> 1
        ])->add('lien')->add('da')->add('manager')->add('managr')->add('equipe')->add('livrable')->add('quantite')->add('produit')
        ->add('deadline')->add('commercial')->add('delancement')->add('brief')->add('reception')->add('nom')->add('devis')
        ->add('designation')->add('statut', ChoiceType::class, [
                'choices'  => [
                    'EN ATTENTE' => 'EN ATTENTE',
                    'EN COURS' => 'EN COURS',
                    'URGENT' => 'URGENT',
                    'TERMINEE'=>'TERMINEE',
                ],
            ])->add('raison' ,TextareaType::class,[
        'required'   => false])->add('avancement')->add('lienEspace')->add('lienProd');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PlaningBundle\Entity\Commande'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'planingbundle_commande';
    }

}
