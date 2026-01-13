<?php
    require_once('conn/conn.php');
    $id_edit = intval($_GET['id']); //Conversor para tipo INT. Medida de segurança
    $tabela_edit = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['tabela']); //Sanitização para permisão somente de letras, números e underline. Medida de segurança

    $sql = mysqli_query($conn, "SELECT * FROM $tabela_edit WHERE id=$id_edit") or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($sql);

    $temp1 = $row['fk_departamento'];
    $temp2 = $row['fk_setor'];
    $temp3 = $row['fk_funcao'];
    $temp4 = $row['fk_grupo'];
    $sal = str_replace('.',',', $row['salario']);

    //Consultas para preencher OPTION com valores registrado para edição.
    $sql2 = mysqli_query($conn,"SELECT 
                                    d.nome AS dnome,
                                    s.nome AS snome,
                                    f.nome AS fnome,
                                    g.nome AS gnome
                                FROM 
                                    departamento d,
                                    setor s,
                                    funcao f,
                                    grupo g
                                WHERE 
                                    d.id = '$temp1' AND
                                    s.id = '$temp2' AND
                                    f.id = '$temp3' AND
                                    g.id = '$temp4' ") or die(mysqli_error($conn));
    $row2 = mysqli_fetch_assoc($sql2);

    if ($row['alterado'] == NULL){
        $dataAlt = "Sem dado";
    } else {
        $dataAlt = date("H:i:s - d/m/Y", strtotime($row['alterado']));
    }
?>

<div class="div-us-edit" id="div-us-edit">
    <ul class="breadcrumb">
        <li><a href="" onclick="voltarPagina()"><span class="icon-start"></span>Funcionários</a></li>
        <li><a href="" onclick="voltarPagina()"><span></span>Edição</a></li>
    </ul>
    <form name="form-us-edit" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
        <table class="main-table-form" id="main-table-form" align="center">
            <tr align="left">
                <td colspan="2" style="padding-bottom:20px;"><h2>Editar Funcionário</h2></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Matrícula</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="matricula" placeholder="Número da Matrícula" value="<?php echo $row['matr'];?>" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6)" maxlength="6"></input></td>
            </tr>
            <tr aligh="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Nome</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="nome" placeholder="Nome do funcionário" value="<?php echo $row['nome'];?>" required></input></td>
            </tr>
            <tr aligh="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Departamento</td>
                <td class="td-tit" name="td-tit">
                    <select name="dp">
                        <option value="<?php echo $temp1?>"><?php echo $temp1." - ".$row2['dnome'];?></option>
                        <?php
                        $sql_dp = mysqli_query($conn, "SELECT id, nome FROM departamento WHERE ativo=1 AND id <> '$temp1' ORDER BY id ASC")or die(mysqli_error($conn));
                        if (mysqli_num_rows($sql_dp) > 0) {
                            while ($row_dp = mysqli_fetch_assoc($sql_dp)) {
                                 ?>
                                 <option value="<?php echo $row_dp['id'];?>"><?php echo $row_dp['id']." - ".$row_dp['nome'];?></option>
                                 <?php
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr aligh="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Setor</td>
                <td class="td-tit" name="td-tit">
                    <select name="setor">
                        <option value="<?php echo $temp2;?>"><?php echo $temp2." - ".$row2['snome'];?></option>
                        <?php
                        $sql_setor = mysqli_query($conn, "SELECT id, nome FROM setor WHERE ativo=1 AND id <> '$temp2' ORDER BY id ASC")or die(mysqli_error($conn));
                        if (mysqli_num_rows($sql_setor) > 0) {
                            while ($row_setor = mysqli_fetch_assoc($sql_setor)) {
                                 ?>
                                 <option value="<?php echo $row_setor['id'];?>"><?php echo $row_setor['id']." - ".$row_setor['nome'];?></option>
                                 <?php
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr aligh="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Função</td>
                <td class="td-tit" name="td-tit">
                    <select name="funcao">
                        <option value="<?php echo $temp3;?>"><?php echo $temp3." - ".$row2['fnome'];?></option>
                        <?php
                        $sql_funcao = mysqli_query($conn, "SELECT id, nome FROM funcao WHERE ativo=1 AND id <> '$temp3' ORDER BY id ASC")or die(mysqli_error($conn));
                        if (mysqli_num_rows($sql_funcao) > 0) {
                            while ($row_funcao = mysqli_fetch_assoc($sql_funcao)) {
                                 ?>
                                 <option value="<?php echo $row_funcao['id'];?>"><?php echo $row_funcao['id']." - ".$row_funcao['nome'];?></option>
                                 <?php
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr aligh="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">GRUPO</td>
                <td class="td-tit" name="td-tit">
                    <select name="grupo">
                        <option value="<?php echo $temp4;?>"><?php echo $temp4." - ".$row2['gnome'];?></option>
                        <?php
                        $sql_grupo = mysqli_query($conn, "SELECT id, nome FROM grupo WHERE ativo=1 AND id <> '$temp4' ORDER BY id ASC")or die(mysqli_error($conn));
                        if (mysqli_num_rows($sql_grupo) > 0) {
                            while ($row_grupo = mysqli_fetch_assoc($sql_grupo)) {
                                 ?>
                                 <option value="<?php echo $row_grupo['id'];?>"><?php echo $row_grupo['id']." - ".$row_grupo['nome'];?></option>
                                 <?php
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr aligh="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Salário(R$)</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="salario" value="<?php echo $sal;?>" required oninput="this.value = this.value.replace(/[^0-9,]/g, '').replace(/(,.*?),/g, '$1').replace(/,(\d{2}).*$/, ',$1')"></input></td>
            </tr>
            <tr aligh="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Afastado?</td>
                <td class="td-tit" name="td-tit">
                    <input type="radio" class="iradio" name="afastado" value="1" required <?php if($row['afastado'] == 1) {echo "checked";}?> >Sim</input>
                    <input type="radio" class="iradio" name="afastado" value="0" required <?php if($row['afastado'] == 0) {echo "checked";}?> >Não</input>
                </td>
            </tr>
            <tr align="center">
                <td colspan="2">
                    <input onclick="editRegistro('<?php echo $id_edit;?>','<?php echo $tabela_edit;?>')" type="button" class="sub-create" name="sub-create" value="Enviar"></input>
                    <input onclick="voltarPagina()" type="button" class="sub-back" name="sub-back" value="Voltar"></input>
                </td>
            </tr>
        </table>
    </form>
</div>