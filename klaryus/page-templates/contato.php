<?php /* Template Name: Contato */
    get_header(); 
?>
<?php get_template_part('template-parts/banner'); ?>
<section class="contato content">
    <div class="container">
    <h2 class="title"><?php echo get_the_title(); ?></h2>
    <?php if(get_the_excerpt()) : ?>
        <p><?php echo get_the_excerpt(); ?></p>
    <?php endif; ?>
    </div>
    <div class="contact-tabs">
    <nav class="contact-tabs-navigation">
        <ul>
        <li class="active"><a href="javascript:void(0)" data-tab="consumidor" title="Sou Consumidor">Sou Consumidor</a></li>
        <li><a href="javascript:void(0)" data-tab="parceiro" title="Sou Parceiro">Sou Parceiro</a></li>
        </ul>
    </nav>
    <form class="contact-form" method="POST" novalidate>
        <div class="container">
        <h3 class="title">Sou Consumidor</h3>
        <div class="contact-tab-content active">
            <span>
            <input required="required" name="nome" type="text" placeholder="Seu Nome">
            </span>
            <span>
            <input required="required" name="email" type="email" placeholder="Seu E-mail">
            </span>     
            <span class="mid-input">
            <input required="required" name="estado" type="text" placeholder="Seu Estado">
            </span>      
            <span class="mid-input">
            <input required="required" name="cidade" type="text" placeholder="Sua Cidade">
            </span>   
            <span class="mid-input empresa-field">
            <input required="required" name="empresa" type="text" placeholder="Sua Empresa">
            </span>      
            <span class="mid-input empresa-field">
            <input required="required" name="cnpj" type="text" placeholder="CNPJ" class="cnpj">
            </span>                       
            <span>
            <select required="required" name="assunto" id="">
                <option value="">Selecione o Assunto</option>
                <option value="Dúvida">Dúvida</option>
                <option value="Sugestão">Sugestão</option>
            </select>
            </span>             
            <span>
            <textarea required="required" name="mensagem" placeholder="Mensagem"></textarea>
            </span>     
        </div> 
        <button class="btn-1 btn">Enviar</button>
        <input required="required" id="form_type" name="form_type" type="hidden" value="consumidor">
        </div>
    </form>
    </div>
</section>
<section class="distribuidores">
    <div class="container">
    <h2 class="title">distribuidores</h2>
    <nav class="distribuidores-navigation">
        <ul>
            <li>
                <a id="seja_fornecedor" href="javascript:void(0)" title="Seja um deles" class="btn btn-1">Seja um deles</a>
            </li>
            <li>
                <a href="<?php echo get_permalink( get_page_by_path( 'fornecedores' ) ); ?>" title="Onde encontrar" class="btn btn-1">Onde encontrar</a>
            </li>
        </ul>
    </nav>
    </div>
</section>
<?php get_footer(); ?>