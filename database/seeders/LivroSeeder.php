<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LivroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $livros = [
            'Direito' => [
                ['Curso de Direito Constitucional', 'Gilmar Mendes, Inocêncio Mártires Coelho e Paulo Gustavo Gonet Branco', 'Saraiva', 2024, 'Abordagem completa do direito constitucional, incluindo teoria geral, direitos fundamentais e controle de constitucionalidade.'],
                ['Manual de Direito Constitucional', 'Alexandre de Moraes', 'Atlas', 2023, 'Obra de referência com a doutrina constitucional aplicada, atualizada com as últimas reformas.'],
                ['Curso de Direito Civil Brasileiro - Teoria Geral do Direito Civil', 'Caio Mário da Silva Pereira', 'Forense', 2023, 'Análise da parte geral do direito civil, das pessoas aos bens e fatos jurídicos.'],
                ['Curso de Direito Civil - Direito das Obrigações', 'Maria Helena Diniz', 'Saraiva', 2024, 'Estudo sistematizado das obrigações, contratos e responsabilidade civil.'],
                ['Direito Civil Brasileiro - Contratos e Atos Unilaterais', 'Carlos Roberto Gonçalves', 'Saraiva', 2023, 'Obra didática sobre a teoria geral dos contratos e as espécies contratuais.'],
                ['Manual de Direito Administrativo', 'Matheus Carvalho', 'Juspodivm', 2024, 'Teoria e prática do direito administrativo, com esquemas e jurisprudência atualizada.'],
                ['Curso de Direito Administrativo', 'Celso Antônio Bandeira de Mello', 'Malheiros', 2023, 'Clássico da doutrina administrativista brasileira, com rigor técnico e profundidade.'],
                ['Curso de Direito Penal - Parte Geral', 'Cleber Masson', 'Método', 2024, 'Estudo completo da parte geral do Código Penal, com doutrina e jurisprudência.'],
                ['Manual de Direito Penal', 'Rogério Greco', 'Atlas', 2023, 'Manual didático de direito penal, ideal para concursos e graduação.'],
                ['Curso de Processo Penal', 'Aury Lopes Jr.', 'Saraiva', 2024, 'Perspectiva garantista do processo penal, com análise crítica do sistema brasileiro.'],
                ['Direito do Trabalho', 'Maurício Godinho Delgado', 'LTr', 2024, 'Tratado sobre o direito individual e coletivo do trabalho, obra de referência nacional.'],
                ['Curso de Direito Tributário', 'Eduardo Sabbag', 'Atlas', 2024, 'Teoria geral do tributo, limitações ao poder de tributar e tributos em espécie.'],
                ['Curso de Direito Processual Civil', 'Fredie Didier Jr.', 'Juspodivm', 2024, 'Obra completa sobre o novo Código de Processo Civil, com fundamentação dogmática.'],
                ['Curso de Direito Empresarial - Direito Societário', 'Ricardo Negrão', 'Saraiva', 2023, 'Estudo das sociedades empresárias, do registro de empresa ao direito societário.'],
                ['Direito Internacional Público', 'Valério de Oliveira Mazzuoli', 'Forense', 2024, 'Tratado sobre as fontes, sujeitos e temas do direito internacional contemporâneo.'],
                ['Curso de Direito Previdenciário', 'Ivan Kertzman', 'Juspodivm', 2024, 'Aspectos teóricos e práticos do regime geral de previdência social.'],
                ['Manual de Direito do Consumidor', 'Cláudia Lima Marques e Antonio Herman Benjamin', 'RT', 2023, 'Doutrina e jurisprudência sobre a proteção do consumidor no ordenamento brasileiro.'],
                ['Curso de Direito Ambiental', 'Paulo de Bessa Antunes', 'Forense', 2024, 'Fundamentos do direito ambiental, licenciamento e tutela dos recursos naturais.'],
                ['Curso de Direito Constitucional Positivo', 'José Afonso da Silva', 'Malheiros', 2023, 'Obra clássica de direito constitucional, com ênfase na Constituição Federal de 1988.'],
                ['Manual de Direito Previdenciário e Prática Previdenciária', 'Carlos Alberto Pereira de Castro e João Batista Lazzari', 'Forense', 2024, 'Teoria e prática previdenciária, incluindo cálculo de benefícios e processos administrativos.'],
            ],

            'TI' => [
                ['Algoritmos: Teoria e Prática', 'Thomas H. Cormen, Charles E. Leiserson, Ronald L. Rivest e Clifford Stein', 'Elsevier', 2012, 'O clássico da análise de algoritmos, cobrindo estruturas de dados, ordenação e grafos.'],
                ['Estruturas de Dados e Algoritmos em Java', 'Robert Lafore', 'Bookman', 2017, 'Introdução prática a estruturas de dados e algoritmos com implementações em Java.'],
                ['Código Limpo: Habilidades Práticas do Agile Software', 'Robert C. Martin', 'Alta Books', 2009, 'Princípios e boas práticas para escrever código legível e sustentável.'],
                ['Arquitetura Limpa: O Guia do Artesão para Estrutura e Design de Software', 'Robert C. Martin', 'Alta Books', 2019, 'Fundamentos de arquitetura de software, camadas, componentes e design estruturado.'],
                ['Engenharia de Software: Uma Abordagem Profissional', 'Roger S. Pressman e Bruce R. Maxim', 'AMGH', 2021, 'Visão abrangente do processo de engenharia de software, da análise à manutenção.'],
                ['Engenharia de Software Moderna', 'Marco Tulio Valente', 'Independente', 2020, 'Práticas modernas de desenvolvimento, incluindo refatoração, testes e arquitetura.'],
                ['Sistemas de Banco de Dados', 'Ramez Elmasri e Shamkant B. Navathe', 'Pearson', 2018, 'Fundamentos de banco de dados: modelo relacional, SQL, projeto e normalização.'],
                ['Redes de Computadores', 'Andrew S. Tanenbaum e Nick Feamster', 'Pearson', 2021, 'Visão estruturada das camadas de rede, protocolos e arquiteturas de comunicação.'],
                ['Sistemas Operacionais Modernos', 'Andrew S. Tanenbaum e Herbert Bos', 'Pearson', 2016, 'Conceitos de sistemas operacionais: processos, memória, arquivos e segurança.'],
                ['Padrões de Projeto: Soluções Reutilizáveis de Software Orientado a Objetos', 'Erich Gamma, Richard Helm, Ralph Johnson e John Vlissides', 'Bookman', 2000, 'O livro da Gangue dos Quatro, catálogo clássico de padrões de projeto.'],
                ['Use a Cabeça! Padrões de Projetos', 'Eric Freeman e Elisabeth Robson', 'Alta Books', 2015, 'Abordagem visual e didática dos principais padrões de projeto GoF.'],
                ['Introdução à Programação com Python', 'Paul Deitel e Harvey Deitel', 'Pearson', 2021, 'Fundamentos de programação e da linguagem Python para iniciantes.'],
                ['Compiladores: Princípios, Técnicas e Ferramentas', 'Alfred V. Aho, Monica S. Lam, Ravi Sethi e Jeffrey D. Ullman', 'Pearson', 2008, 'O livro do Dragão, referência em análise léxica, sintática e geração de código.'],
                ['Inteligência Artificial: Uma Abordagem Moderna', 'Stuart Russell e Peter Norvig', 'Pearson', 2013, 'Tratado sobre IA: busca, aprendizado, percepção, linguagem e robótica.'],
                ['Aprendizado de Máquina', 'Tom M. Mitchell', 'Bookman', 2021, 'Fundamentos teóricos e algoritmos de aprendizado de máquina supervisionado e não supervisionado.'],
                ['Criptografia e Segurança de Redes', 'William Stallings', 'Pearson', 2018, 'Princípios de criptografia, segurança de rede e garantia de segurança da informação.'],
                ['Matemática Discreta e suas Aplicações', 'Kenneth H. Rosen', 'AMGH', 2009, 'Base matemática para computação: lógica, conjuntos, grafos e combinatória.'],
                ['Lógica de Programação e Estrutura de Dados', 'Nivio Ziviani', 'Cengage', 2010, 'Algoritmos e estruturas de dados clássicas com implementações em linguagem C.'],
                ['Algoritmos em Linguagem C', 'Paulo Feofiloff', 'Campus', 2009, 'Implementação de algoritmos e estruturas de dados em C, da ordenação aos grafos.'],
                ['Computação: Uma Visão Abrangente', 'J. Glenn Brookshear e Dennis Brylow', 'Bookman', 2018, 'Panorama introdutório das ciências da computação, de hardware a inteligência artificial.'],
            ],

            'Saúde' => [
                ['Anatomia de Gray: Anatomia Clínica para Estudantes', 'Richard L. Drake, A. Wayne Vogl e Adam W. M. Mitchell', 'Elsevier', 2015, 'Anatomia humana com ênfase clínica, organizada por regiões do corpo.'],
                ['Princípios de Anatomia Humana e Fisiologia', 'Gerard J. Tortora e Bryan Derrickson', 'Artmed', 2019, 'Introdução integrada à anatomia e fisiologia do corpo humano.'],
                ['Harper: Bioquímica Ilustrada', 'Denise R. Ferrier', 'AMGH', 2019, 'Bioquímica médica ilustrada, das vias metabólicas aos mecanismos moleculares.'],
                ['Farmacologia Básica e Clínica', 'Bertram G. Katzung e Anthony J. Trevor', 'AMGH', 2021, 'Farmacologia sistêmica e clínica, com ênfase em mecanismos de ação.'],
                ['Farmacologia', 'H. P. Rang, J. M. Ritter, R. J. Flower e G. Henderson', 'Elsevier', 2016, 'Obra clássica que relaciona farmacologia básica à prática clínica.'],
                ['Microbiologia Médica', 'Patrick R. Murray, Ken S. Rosenthal e Michael A. Pfaller', 'Guanabara Koogan', 2020, 'Micro-organismos de importância médica, da identificação ao tratamento.'],
                ['Parasitologia Humana', 'David Pereira Neves', 'Atheneu', 2016, 'Estudo dos parasitas humanos, ciclo biológico, patogenia e diagnóstico.'],
                ['Robbins & Cotran: Bases Patológicas das Doenças', 'Vinay Kumar, Abul K. Abbas e Jon C. Aster', 'Elsevier', 2021, 'Referência em patologia geral e sistêmica, com bases moleculares das doenças.'],
                ['Exame Clínico: Semiologia Médica', 'Celmo Celeno Porto', 'Guanabara Koogan', 2022, 'Guia completo da semiologia médica: anamnese, exame físico e propedêutica.'],
                ['Clínica Médica', 'Antônio Carlos Lopes', 'Manole', 2017, 'Condutas diagnósticas e terapêuticas nas principais síndromes clínicas.'],
                ['Epidemiologia & Saúde', 'Maria Zélia Rouquayrol e Marcelo Gurgel Carlos da Silva', 'MedBook', 2018, 'Fundamentos de epidemiologia, indicadores de saúde e vigilância.'],
                ['Fundamentos de Enfermagem', 'Patricia A. Potter e Anne G. Perry', 'Elsevier', 2018, 'Teorias e práticas do cuidado de enfermagem, da avaliação à intervenção.'],
                ['Saúde Coletiva: Teoria e Prática', 'Jairnilson Silva Paim e Naomar de Almeida Filho', 'MedBook', 2020, 'História, políticas e práticas de saúde pública e coletiva no Brasil.'],
                ['Krause: Alimentos, Nutrição e Dietoterapia', 'L. Kathleen Mahan e Janice L. Raymond', 'Elsevier', 2019, 'Nutrição clínica e dietoterapia nas diferentes fases da vida e condições clínicas.'],
                ['Bioestatística: Teoria e Aplicações', 'Sonia Vieira', 'Guanabara Koogan', 2018, 'Métodos estatísticos aplicados às ciências da saúde.'],
                ['Imunologia Celular e Molecular', 'Abul K. Abbas, Andrew H. Lichtman e Shiv Pillai', 'Elsevier', 2019, 'Fundamentos da imunologia, da resposta inata à resposta adaptativa.'],
                ['Genética Médica', 'Lynn B. Jorde, John C. Carey e Michael J. Bamshad', 'Guanabara Koogan', 2017, 'Bases genéticas das doenças humanas e aplicações clínicas.'],
                ['Histologia Básica', 'Luiz Carlos Junqueira e José Carneiro', 'Guanabara Koogan', 2019, 'Estrutura microscópica dos tecidos e órgãos humanos.'],
                ['Fisiologia Humana', 'Rodney A. Rhoades e David R. Bell', 'Guanabara Koogan', 2017, 'Mecanismos fisiológicos dos sistemas do corpo humano.'],
                ['Bioquímica Clínica', 'William J. Marshall e Stephen K. Bangert', 'Elsevier', 2017, 'Interpretação laboratorial e princípios da bioquímica aplicada à clínica.'],
            ],

            'Fisioterapia' => [
                ['Fisioterapia: Avaliação e Tratamento', 'Susan B. O\'Sullivan, Thomas J. Schmitz e George D. Fulk', 'Manole', 2020, 'Métodos de avaliação e intervenção fisioterapêutica nas diferentes disfunções.'],
                ['Cinesiologia do Aparelho Musculoesquelético', 'Donald A. Neumann', 'Elsevier', 2011, 'Base cinesiológica da biomecânica humana, com enfoque no movimento.'],
                ['Exame Clínico dos Sistemas Musculoesquelético, Neurológico e Vascular', 'Stanley Hoppenfeld', 'Guanabara Koogan', 2018, 'Exame ortopédico e neurológico passo a passo para avaliação fisioterapêutica.'],
                ['Músculos: Provas e Funções', 'Florence Peterson Kendall, Elizabeth Kendall McCreary e Patricia Geise Provance', 'Manole', 2017, 'Avaliação da força e alongamento muscular com testes posturais.'],
                ['Fisioterapia Traumato-Ortopédica', 'James R. Andrews, G. L. Harrelson e Kevin E. Wilk', 'Manole', 2016, 'Condutas fisioterapêuticas nas lesões do aparelho locomotor e pós-operatório.'],
                ['Fisioterapia Respiratória', 'George Jerre Vieira Sarmento', 'Manole', 2017, 'Avaliação e técnicas de reabilitação respiratória em adultos e crianças.'],
                ['Fisioterapia Neurofuncional', 'Darcy Ann Umphred', 'Guanabara Koogan', 2019, 'Abordagens de avaliação e tratamento das disfunções neurológicas.'],
                ['Fisioterapia Aquática', 'Richard G. Ruoti, David M. Morris e Andrew J. Cole', 'Manole', 2015, 'Fundamentos e aplicações da hidroterapia na reabilitação funcional.'],
                ['Eletroterapia: Fundamentos e Prática', 'João Eduardo de Araújo', 'Guanabara Koogan', 2016, 'Recursos eletrofísicos e suas aplicações clínicas em fisioterapia.'],
                ['Fisioterapia na Saúde da Mulher', 'Janet Stephenson', 'Manole', 2014, 'Avaliação e tratamento das disfunções do assoalho pélvico e saúde da mulher.'],
                ['Recursos Terapêuticos Manuais', 'Pamela E. Houghton e Peggy A. Houglum', 'Manole', 2018, 'Técnicas de terapia manual, mobilização articular e massagem terapêutica.'],
                ['Fisioterapia Dermatofuncional: Fundamentos, Recursos e Patologias', 'Guilherme Guirro e Elaine Caldeira de Oliveira Guirro', 'Manole', 2016, 'Tratamento das disfunções estéticas e dermatofuncionais pela fisioterapia.'],
                ['Neuromecânica do Movimento Humano', 'Roger M. Enoka', 'Artmed', 2013, 'Bases biomecânicas e neuromusculares do movimento humano.'],
                ['Fisioterapia Preventiva: Fundamentos e Aplicações', 'Elisabete Pereira de Lima e Luciana de Mello Louzada', 'Manole', 2015, 'Programas de promoção da saúde e prevenção de agravos em fisioterapia.'],
                ['Fisioterapia Pediátrica: Avaliação e Tratamento', 'Susan E. Effgen', 'Manole', 2018, 'Reabilitação de crianças com disfunções neuromotoras e desenvolvimento motor.'],
                ['Fisioterapia Geriátrica: O Envelhecer e a Reabilitação', 'Maria Beatriz Rodrigues de Souza', 'Manole', 2017, 'Avaliação e tratamento do idoso com enfoque na funcionalidade e prevenção de quedas.'],
                ['Manipulação Vertebral: Técnica de Maitland', 'Geoffrey D. Maitland', 'Guanabara Koogan', 2016, 'Técnicas de mobilização e manipulação da coluna vertebral segundo o conceito Maitland.'],
                ['Anatomia Palpatória', 'Serge Tixa', 'Manole', 2017, 'Guia prático de palpação da superfície anatômica e estruturas profundas.'],
                ['Fisioterapia Cardiovascular', 'Mark A. Williams e James A. Pawelczyk', 'Manole', 2015, 'Avaliação e reabilitação cardíaca de pacientes cardiopatas.'],
                ['Prescrição de Exercícios Terapêuticos', 'Ellen R. Costantino e Michael J. Zurakowski', 'Manole', 2016, 'Princípios de prescrição de exercícios para a reabilitação musculoesquelética.'],
            ],

            'Medicina Veterinária' => [
                ['Anatomia dos Animais Domésticos', 'K. M. Dyce, W. O. Sack e C. J. G. Wensing', 'Guanabara Koogan', 2019, 'Anatomia sistêmica dos animais domésticos com enfoque aplicado.'],
                ['Fisiologia Veterinária', 'William O. Reece', 'Guanabara Koogan', 2018, 'Fisiologia comparada das espécies domésticas, incluindo aves e equinos.'],
                ['Tratado de Medicina Interna Veterinária', 'Stephen J. Ettinger e Edward C. Feldman', 'Elsevier', 2017, 'Referência mundial em clínica e medicina interna de pequenos animais.'],
                ['Patologia Veterinária', 'Thomas C. Jones, Ronald D. Hunt e Norval W. King', 'Manole', 2015, 'Bases patológicas das doenças nos animais domésticos.'],
                ['Farmacologia e Terapêutica Veterinária', 'H. Richard Adams', 'Guanabara Koogan', 2018, 'Farmacologia aplicada à terapêutica das espécies de interesse veterinário.'],
                ['Medicina Interna de Grandes Animais', 'Bradford P. Smith', 'Elsevier', 2018, 'Diagnóstico e tratamento das enfermidades de bovinos, equinos e pequenos ruminantes.'],
                ['Parasitologia Veterinária', 'M. A. Taylor, R. L. Coop e R. L. Wall', 'Guanabara Koogan', 2017, 'Parasitos de importância veterinária: morfologia, ciclos e controle.'],
                ['Microbiologia Veterinária e Doenças Infecciosas', 'P. J. Quinn, B. K. Markey e F. C. Leonard', 'Artmed', 2016, 'Micro-organismos patogênicos e doenças infecciosas de animais domésticos.'],
                ['Cirurgia de Pequenos Animais', 'Theresa Welch Fossum', 'Elsevier', 2019, 'Cirurgia geral e especializada em cães e gatos, do preparo ao pós-operatório.'],
                ['Anestesiologia Veterinária', 'L. A. Klein', 'Guanabara Koogan', 2018, 'Agentes anestésicos, monitoração e protocolos para as espécies domésticas.'],
                ['Semiologia Veterinária', 'Francisco Leydson Feitosa', 'Manole', 2020, 'Exame clínico e propedêutica das principais espécies de interesse veterinário.'],
                ['Nutrição de Cães e Gatos', 'Linda P. Case, Leighann Daristotle e Michael G. Hayek', 'Artmed', 2017, 'Fundamentos nutricionais e dietas para cães e gatos nas diferentes fases.'],
                ['Imunologia Veterinária', 'Ian R. Tizard', 'Guanabara Koogan', 2019, 'Sistema imune animal, vacinação e imunopatologia veterinária.'],
                ['Reprodução Animal', 'E. S. E. Hafez e B. Hafez', 'Manole', 2016, 'Fisiologia da reprodução, biotecnologias e manejo reprodutivo das espécies.'],
                ['Doenças Infecciosas em Cães e Gatos', 'Craig E. Greene', 'Elsevier', 2017, 'Doenças virais, bacterianas e fúngicas de pequenos animais.'],
                ['Diagnóstico por Imagem em Medicina Veterinária', 'Donald E. Thrall', 'Guanabara Koogan', 2019, 'Radiologia, ultrassonografia e tomografia aplicadas à clínica veterinária.'],
                ['Epidemiologia Veterinária: Princípios e Práticas', 'José Fernando Garcia', 'Roca', 2018, 'Métodos epidemiológicos aplicados à sanidade animal e saúde pública.'],
                ['Bem-Estar Animal: Conceitos e Aplicações', 'Valquíria da Silva e Nei Moreira', 'MedVet', 2019, 'Princípios éticos e práticos de bem-estar nas diferentes espécies e sistemas.'],
                ['Odontologia Veterinária', 'Steven E. Holmstrom, Patricia Frost e Robert L. Gammon', 'Manole', 2016, 'Exame, limpeza e cirurgia odontológica em pequenos animais.'],
                ['Toxicologia Veterinária', 'K. Gupta', 'Artmed', 2017, 'Intoxicações por plantas, fármacos e agentes químicos nos animais.'],
            ],

            'Letras' => [
                ['Curso de Linguística Geral', 'Ferdinand de Saussure', 'Cultrix', 2012, 'Obra fundadora da linguística moderna, com os conceitos de língua, fala e signo.'],
                ['Gramática da Língua Portuguesa', 'Celso Cunha e Lindley Cintra', 'Leya', 2017, 'Gramática de referência do português contemporâneo do Brasil e de Portugal.'],
                ['Moderna Gramática Portuguesa', 'Evanildo Bechara', 'Nova Fronteira', 2019, 'Gramática normativa completa da língua portuguesa.'],
                ['História Concisa da Literatura Brasileira', 'Alfredo Bosi', 'Cultrix', 2017, 'Panorama da literatura brasileira do quinhentismo ao contemporâneo.'],
                ['Teoria da Literatura: Uma Introdução', 'Terry Eagleton', 'Martins Fontes', 2011, 'Introdução crítica às principais correntes da teoria literária.'],
                ['Literatura Portuguesa', 'Massaud Moisés', 'Cultrix', 2016, 'História da literatura de língua portuguesa, dos trovadores ao modernismo.'],
                ['A Criação Literária', 'Massaud Moisés', 'Cultrix', 2013, 'Prosa, poesia e ensaio analisados a partir dos fundamentos da criação artística.'],
                ['História da Literatura Ocidental', 'Otto Maria Carpeaux', 'Leya', 2011, 'Obra monumental sobre a literatura ocidental, da antiguidade ao século XX.'],
                ['Introdução à Linguística Textual', 'Ingedore Villaça Koch', 'Contexto', 2018, 'Coesão e coerência textuais, gêneros e estratégias de construção do texto.'],
                ['Sociolinguística: Introdução à Variação e Mudança', 'Stella Maris Bortoni-Ricardo', 'Parábola', 2014, 'Relação entre língua e sociedade, variação e ensino do português.'],
                ['Semântica', 'Mário Vilela e Graça Rio-Torto', 'Contexto', 2013, 'Significado, sentidos e relações semânticas na língua portuguesa.'],
                ['Pragmática: A Linguagem no Uso', 'V. K. Bhatia e A. P. Santos', 'Contexto', 2015, 'O sentido contextualizado e os atos de fala na interação verbal.'],
                ['Análise de Discurso: Questões Teóricas e Metodológicas', 'Dominique Maingueneau', 'Parábola', 2016, 'Fundamentos da análise do discurso francesa e suas aplicações.'],
                ['Poética', 'Aristóteles', 'Editora 34', 2015, 'Tratado clássico sobre a tragédia, a épica e a natureza da poesia.'],
                ['Estética: A História da Filosofia da Arte', 'Benedito Nunes', 'Ática', 2013, 'Percursos da filosofia da arte, da antiguidade à estética contemporânea.'],
                ['A Linguagem e o Pensamento', 'Safir e Whorf', 'Cultrix', 2012, 'Relação entre linguagem, cultura e percepção do mundo.'],
                ['Filologia e Linguística Portuguesa', 'Joaquim Mattoso Câmara Jr.', 'Padrão', 2015, 'Estudos de filologia e de fonologia do português brasileiro.'],
                ['Tradução: Teoria e Prática', 'Paulo Rónai', 'Contexto', 2014, 'Teorias da tradução e análise de casos práticos da tradução literária.'],
                ['O Português do Brasil: Língua e Sociedade', 'Rosa Virgínia Mattos e Silva', 'Contexto', 2013, 'História social do português brasileiro e suas variedades.'],
                ['Estruturas Morfológicas do Português', 'Mário A. Perini', 'Ática', 2012, 'Processos de formação de palavras e estrutura interna da língua.'],
            ],
        ];

        foreach ($livros as $categoria => $livrosDaCategoria) {
            foreach ($livrosDaCategoria as $livro) {
                DB::table('livros')->insert([
                    'titulo' => $livro[0],
                    'autor' => $livro[1],
                    'editora' => $livro[2],
                    'ano' => $livro[3],
                    'categoria' => $categoria,
                    'descricao' => $livro[4],
                    'arquivo_pdf' => null,
                    'quantidade' => rand(2, 10),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
