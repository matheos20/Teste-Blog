<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\User;
use App\Enum\AccountTypeEnum;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{

    private $type;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->type = $options['type'];
        $builder
            ->add('Titre')
            ->add('Texte');

        if ($this->type == AccountTypeEnum::ADMIN) {
            $builder
                ->add('auteur',EntityType::class, [
                        'class' => User::class,
                        'choice_label' => 'fullname',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('u')
                                ->where('u.type = :type')
                                ->setParameter('type', AccountTypeEnum::AUTEUR)
                                ->orderBy('u.fullname', 'ASC');
                        },
                    ]
                );
        }

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);

        $resolver->setRequired(['type']);
    }
}
