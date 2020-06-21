<?php

namespace App\Form;

use App\Entity\Property;
use App\Entity\Preference;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('surface')
            ->add('rooms')
            ->add('bedrooms')
            ->add('floor')
            ->add('price')
           // ->add('heat', ChoiceType::class, ['choices' => $this->getChoices()])
            ->add('heat', ChoiceType::class, [
                'choices'=> array_flip(Property::HEAT)
            ])
            ->add('preferences', EntityType::class, [
                'class' => Preference::class,
                'required' => false,
                'choice_label'=>'name',
                'multiple'=> true
            ])
            //->add('imagefile', FileType::class, [
            //    "required" => false
            //])
            ->add('pictureFiles', FileType::class, [
                "required" => false,
                'multiple' => true
            ])
            ->add('city')
            ->add('address')
            ->add('postal_code')
            ->add('lat', HiddenType::class)
            ->add('lng', HiddenType::class)
            ->add('sold')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
            'translation_domain' => 'forms'
        ]);
    }
 /*   private function getChoices()
    {
        $choices = Property::HEAT;
        $output=[];
        foreach($choices as $k=>$v)
        {
            $output[$v]=$k;
        }
        return $output;
    }*/
}
