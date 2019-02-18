<?php
/**
 * Created by PhpStorm.
 * User: chinaskijr
 * Date: 17/02/19
 * Time: 17:58
 */

namespace App\Form;


use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('isbn', TextType::class)
            ->add('title', TextType::class)
            ->add('editor', TextType::class)
            ->add('keywords', CollectionType::class, [
                'entry_type' => KeywordType::class,
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('Submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);    }
}