<?php

namespace App\Command;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:stats',
    description: 'Affiche des statistiques sur Flanano',
)]
class StatsCommand extends Command
{
    private UserRepository $userRepository;
    private ProductRepository $productRepository;
    private CategoryRepository $categoryRepository;

    public function __construct(
        UserRepository $userRepository,
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository
    ) {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Requête
        $userCount = $this->userRepository->count([]);
        $productCount = $this->productRepository->count([]);
        $categories = $this->categoryRepository->findAll();
        $categoryNames = array_map(fn($category) => $category->getName(), $categories);

        $products = $this->productRepository->findAll();
        $totalPrice = array_sum(array_map(fn($product) => $product->getPriceHT(), $products));
        $averagePrice = $productCount > 0 ? $totalPrice / $productCount : 0;

        // Résultats
        $io->title('Statistiques de Flanano');
        $io->section('Utilisateurs');
        $io->text("Nombre total d'utilisateurs : $userCount");

        $io->section('Produits');
        $io->text("Nombre total de produits : $productCount");
        $io->text(sprintf("Prix moyen des produits : %.2f €", $averagePrice));

        $io->section('Catégories de produits');
        $io->listing($categoryNames);

        $io->success('Statistiques générées avec succès.');

        return Command::SUCCESS;
    }
}
