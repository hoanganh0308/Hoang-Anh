Car.prototype.handleInput = function(keyStates){
    if(keyStates[Keys.UP_ARROW])
    {
        this.speed += this.acceleration;
        if(this.speed > this.maxspeed)
            this.speed = this.maxspeed;
    }else if(keyStates[Keys.DOWN_ARROW])
    {
        this.speed -= this.acceleration;
        if(this.speed < this.minspeed)
            this.speed = this.minspeed;
    }
 
    if(keyStates[Keys.LEFT_ARROW])
        this.angle -= this.rotationAngle;
    if(keyStates[Keys.RIGHT_ARROW])
        this.angle += this.rotationAngle;
    // keep the angle as small  as possible
    this.angle = this.angle % _360_RADIAN;
    // decrease the speed base on the friction
    this.speed *= (1 - this.friction);
    if(Math.abs(this.speed)<0.1)
        this.speed = 0;
}
Car.prototype.update = function(){
    var cos = Math.cos(this.angle);
    var sin = Math.sin(this.angle);
 
    if(this.speed!=0)
    {
        // move
        this.cx += cos*this.speed;
        this.cy += sin*this.speed;
        if(this.cx<0)
            this.cx = 0;
        else if(this.cx>this.mapWidth)
            this.cx = this.mapWidth;
 
        if(this.cy<0)
            this.cy = 0;
        else if(this.cy>this.mapHeight)
            this.cy = this.mapHeight;
    }
    // update 4 vertices based on the rotation angle and their original position
    // top-left
    this.vertices[0] = {
        x: Math.floor(this.cx + cos*-this.h_width-sin*-this.h_height),
        y: Math.floor(this.cy + sin*-this.h_width+cos*-this.h_height)
    };
    // top-right
    this.vertices[1] = {
        x: Math.floor(this.cx + cos*this.h_width-sin*-this.h_height),
        y: Math.floor(this.cy + sin*this.h_width+cos*-this.h_height)
    };
    // bottom-right
    this.vertices[2] = {
        x: Math.floor(this.cx + cos*this.h_width-sin*this.h_height),
        y: Math.floor(this.cy + sin*this.h_width+cos*this.h_height)
    };
    // left-bottom
    this.vertices[3] = {
        x: Math.floor(this.cx + cos*-this.h_width-sin*this.h_height),
        y: Math.floor(this.cy + sin*-this.h_width+cos*this.h_height)
    };
    // ...
var friction = ROAD_FRICTION;
 
for(var i=0;i<_car.vertices.length;i++)
{
    var p = _car.vertices[i];

    var index = Math.floor((p.x+p.y*_imageData.width)*4+3);

    if(_imageData.data[index]!=0)
    {
        _context.beginPath();
        _context.arc(p.x, p.y, 4, 0 , 2 * Math.PI, false);
        _context.fill();
        // increase the friction by 0.05 for each vertex (or wheel) collide with grass
        friction += GRASS_FRICTION;
        //break;
    }
}

_car.friction = friction;
// ...
