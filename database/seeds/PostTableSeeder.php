<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('publicacion')->insert([
            'id' => 1,
            'titulo' => '¿Quienes somos?',
            'imagen' => 'https://pbs.twimg.com/media/B2SLocEIQAAddSj.jpg',
            'contenido' => '<p><strong>Fundaci&oacute;n Vida y Camino del Autismo en Guayana&nbsp;</strong>(FUNDAVICA), es una Asociaci&oacute;n Civil de car&aacute;cter privado sin fines de lucro que se constituye con el objetivo de fomentar acciones para la mejora de la integraci&oacute;n social de ni&ntilde;os y adolescentes con problemas del desarrollo dentro del Trastorno del Espectro Autista (TEA).</p> <p>La Fundaci&oacute;n inici&oacute; sus actividades el 4 de Octubre de 2007 con cinco ni&ntilde;os y hasta la fecha se han atendido 75, actualmente recibenterapia 25 aprendices en edades comprendidas de 2 a 13 a&ntilde;os.</p><p>El servicio principal que se ofrece es una ense&ntilde;anza intensiva e individualizada; bajo el m&eacute;todo <strong>ABA (An&aacute;lisis Aplicado a la Conducta),&nbsp;</strong>el cual&nbsp;se aplica de acuerdo a un programa psicoeducativo individualizado que abarca las conductas en d&eacute;ficit de cada ni&ntilde;o en las siguiente &aacute;reas; Comunicaci&oacute;n, Psicomotrocidad, Cognitivo, Cooperaci&oacute;n y Autonom&iacute;a. Este trabajo se realiza por lo minimo 2 horas diarias. Entre otros servicios podemos nombrar; deporte, charlas, seminarios, entretenimientos, talleres tanto a padres como profesores interesados y afectados en este medio tan especial.</p>',
            'created_at' => Carbon::now()->format('Y-m-d h:i:s'),
            'usuario_id' => 1,
            'categoria_id' => 1,
            'estado_id' => 2,
        ]);

        DB::table('publicacion')->insert([
            'id' => 2,
            'titulo' => 'Misión',
            'imagen' => 'https://pbs.twimg.com/media/B2SLocEIQAAddSj.jpg',
            'contenido' => '<p>FUNDAVICA es una Asociaci&oacute;n Civil de car&aacute;cter privado sin fines de lucro con programas de tipo educativo y servicios integrales a la poblaci&oacute;n con s&iacute;ndrome de autismo, que se intercalan en los entornos socio-escolar y laboral, retroaliment&aacute;ndolos seg&uacute;n las condiciones, exigencias y retos en sus potencialidades como seres humanos, aut&oacute;nomos, responsables, justos, fraternos y respetuosos de las diferencias.</p> <p>&nbsp;</p> <p><img src="http://cdn.imagentv.com/resources/defaults/v2/imagen_default300.png" alt="imagen" width="972" height="528" /></p>',
            'created_at' => Carbon::now()->format('Y-m-d h:i:s'),
            'usuario_id' => 1,
            'categoria_id' => 1,
            'estado_id' => 2,
        ]);

        DB::table('publicacion')->insert([
            'id' => 3,
            'titulo' => 'Visión',
            'imagen' => 'https://pbs.twimg.com/media/B2SLocEIQAAddSj.jpg',
            'contenido' => '<p>La Fundaci&oacute;n Vida y Camino del Autista en Guayana (FUNDAVICA) es una Asociaci&oacute;n Civil de car&aacute;cter privado sin fines de lucro dedicada a la intervenci&oacute;n temprana de ni&ntilde;os y ni&ntilde;as con autismo a partir de una pr&aacute;ctica pedag&oacute;gica integracionista que acompa&ntilde;a por intermedio de los procesos, estrategias que potencializan sus habilidades, y los conduce a asumir su entorno frente al Mejoramiento y Calidad de vida.</p>',
            'created_at' => Carbon::now()->format('Y-m-d h:i:s'),
            'usuario_id' => 1,
            'categoria_id' => 1,
            'estado_id' => 2,
        ]);

        DB::table('publicacion')->insert([
            'id' => 4,
            'titulo' => 'Objetivos',
            'imagen' => 'https://pbs.twimg.com/media/B2SLocEIQAAddSj.jpg',
            'contenido' => '<p>Los objetivos primordiales de la fundaci&oacute;n son los siguientes:</p> <ul> <li>Ense&ntilde;ar los requisitos necesarios que permiten a los ni&ntilde;os iniciar el aprendizaje en su entorno social, familiar y escolar.</li> <li>Ofrecer una ense&ntilde;anza intensiva individualizada y adaptada a las necesidades de cada ni&ntilde;o.</li> <li>Ense&ntilde;ar los procesos de comunicaci&oacute;n oral y ofrecer alternativas de comunicaci&oacute;n cuando sean necesarias.</li> <li>Aumentar las habilidades cognoscitivas que permitan un desarrollo lo mas normalizado posible en el &aacute;mbito escolar.</li> <li>Desarrollar las habilidades generales de interacci&oacute;n social que permitan la integraci&oacute;n social.</li> </ul>',
            'created_at' => Carbon::now()->format('Y-m-d h:i:s'),
            'usuario_id' => 1,
            'categoria_id' => 1,
            'estado_id' => 2,
        ]);
    }
}
