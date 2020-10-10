# Teste Delivery Direto

A tarefa deve ser feita usando PHP e você é livre para usar qualquer framework em PHP (ou não usar, se quiser).
Você pode guardar as informações em um banco de dados ou mesmo em um arquivo .txt. Você é livre para escolher a sua abordagem, assim como organizar os arquivos de seu projeto.

Você deve criar um sistema de distribuição que leve em conta a distância dos locais para achar a melhor rota de distribuição. 

Você pode considerar a distância entre cada ponto como uma reta. Abaixo estão as cidades que fazem parte da rota e suas coordenadas.

a,-23.543797,-46.634158
b,-22.910086,-47.059311
c,-23.500147,-47.458557
d,-23.188704,-46.884137
e,-22.124055,-51.386076
f,-20.427292,-51.343513
g,-21.177986,-47.810823
h,-23.932337,-46.330097
i,-23.184146,-45.887737
j,-23.115557,-46.548272
k,-21.996022,-47.431006
l,-22.010785,-47.890079
m,-22.977390,-49.868635
n,-20.420253,-49.975181
o,-21.138111,-48.974366
p,-20.554312,-48.571846
q,-20.535479,-47.399258
r,-21.789480,-48.176770
s,-22.245826,-49.968522

As arestas que representam a ligação de uma cidade a outra estão no arquivo vertices.txt. A rota de distribuição deve se mover exclusivamente pelas arestas descritas np aquivo vertices.txt. Considere que se há uma ligação de ida, então há também a ligação de volta.

Cada linha possui o nome de uma cidade separada por vírgula, por ex a linha:

a,b

representa que existe um caminho de a para b e também existe um caminho de b para a. A distância entre uma cidade e outra deve ser calculada.
 
Você deve criar um sistema de cadastro que grave o nome da cidade e localização em latitude/longitude. Para isso crie uma interface que dê a possibilidade de fazer o cadastro da cidade, ele deve se comunicar com o backend utilizando javascript e ajax.

O arquivo vertices.txt deve servir de guia para a sua implementação, mas a correção se utilizará de outros exemplos também. Não basta que seu programa funcione para o exemplo acima, ele deve funcionar de modo geral.

Considere que o arquivo vertices.txt será lido pela sua solução (você pode usar qualquer comando de leitura de arquivo do php que achar melhor). Você não precisa implementar o cadastro de vértices de um ponto a outro. Basta ler o arquivo para montar a sua rede de cidades.

A sua interface também deve dar a possibilidade de escolher a cidade inicial e a cidade final da sua rota.

Você deve criar um outro botão para fazer a requisição ajax para que o backend faça a decisão de qual será a melhor ordem de visitação das cidades, sendo que a melhor ordem é você percorrer a menor distância possível. O resultado final deve ser mostrado na interface do seu sistema indicando qual é a ordem dos pontos a serem visitados e a distância total percorrida.

Na medida do possível faça comentários em inglês de suas funções no código para entendermos o que você implementou.

## Vertices e Cidades

Os arquivos de banco de dados estao dentro da pasta database

## Rodar

Para Executar o Projeto basta rodar (docker-compose up -d --build) e o projeto subira para a porta 80 no localhost o primeiro build, demora devido que ele ira baixar todas as dependencias
