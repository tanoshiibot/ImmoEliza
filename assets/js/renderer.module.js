
import * as THREE from './libs/three.r119.module.js';
import * as LOADERS from './loaders.module.js';

let canvas, renderer, scene, camera, controls,
    mesh_land, lines_land, mesh_house, points_vegetation;

let init = (land, vegetation, houses, offsets) => {

    // Canvas definition
    canvas = document.createElement('canvas');
    canvas.setAttribute("id", "render");
    let render = document.getElementById("canvas");
    render.appendChild(canvas);

    // Renderer definition
    renderer = new THREE.WebGLRenderer({canvas, alpha: true });
    renderer.setSize(300, 300);

    // Scene definition
    scene = new THREE.Scene();

    // Camera's constants
    const fov = 70;
    const aspect = 300 / 300;
    const near = 0.1;
    const far = 10000;
    camera = new THREE.PerspectiveCamera(fov, aspect, near, far);
    camera.position.set(0, 10, 30);
    camera.lookAt(0, 0, 0);

    // Source: https://github.com/mrdoob/three.js/blob/dev/examples/webgl_lights_hemisphere.html
    // Lights
    const hemiLight = new THREE.HemisphereLight( 0xffffff, 0xffffff, 0.6 );
    hemiLight.color.setHSL( 0.6, 1, 0.6 );
    hemiLight.groundColor.setHSL( 0.095, 1, 0.75 );
    hemiLight.position.set( 0, 50, 0 );
    scene.add(hemiLight);

    const dirLight = new THREE.DirectionalLight( 0xffffff, 1 );
    dirLight.color.setHSL( 0.1, 1, 0.95 );
    dirLight.position.set( - 1, 1.75, 1 );
    dirLight.position.multiplyScalar( 30 );
    scene.add( dirLight );

    dirLight.castShadow = true;
    dirLight.shadow.mapSize.width = 2048;
    dirLight.shadow.mapSize.height = 2048;

    const d = 50;

    dirLight.shadow.camera.left = - d;
    dirLight.shadow.camera.right = d;
    dirLight.shadow.camera.top = d;
    dirLight.shadow.camera.bottom = - d;

    dirLight.shadow.camera.far = 3500;
    dirLight.shadow.bias = - 0.0001;

    // Object rotation
    const x_rotation = - Math.PI / 2;

    // Load house PLY
    mesh_house = new THREE.Group();


    let averageOffset = [0, 0];
    for (let house of houses) {
        const i = house.value[0];
        averageOffset[0] += offsets.house[i].x / offsets.house.length;
        averageOffset[1] += offsets.house[i].y / offsets.house.length;
    }

    for (let house of houses) {

        const i = house.value[0]
        const buffer = house.value[1]


        LOADERS.ply(buffer, (geometry) => {

            // Set mesh color and set double side (avoid see through)
            const material = new THREE.MeshPhongMaterial({color: 0x8F0000, specular: 0x7d4031, shininess: 10, flatShading: true, side: THREE.DoubleSide})
            const mesh = new THREE.Mesh(geometry, material);

            // Allow shadow and translate to (0, 0, 0)
            mesh.receiveShadow = true;
            mesh.geometry.translate(offsets.house[i].x - averageOffset[0], offsets.house[i].y - averageOffset[1], - offsets.house[i].z);
            console.log(offsets.house[i].x, offsets.house[i].y, - offsets.house[i].z);
            mesh.rotation.x = x_rotation;
            mesh_house.add(mesh);
        })
    }

    scene.add(mesh_house)

}

let animate = () => {
    requestAnimationFrame(animate);
    mesh_house.rotation.y += 0.005;
    render()
}

let render = () => {
    renderer.render(scene, camera);
}

// Display functions

let displayHouse = (state) => {
    mesh_house.visible = state
}

export {init, animate, displayHouse};